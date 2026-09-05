"use client";
import { createContext, useContext, useEffect, useRef, useState, useSyncExternalStore, type ReactNode } from "react";
import { Toaster, toast } from "sonner";
import { api } from "@/lib/client";
import type { Cart, Language, StoreSettings, User } from "@/lib/types";

type StoreContext = {
  language: Language; toggleLanguage: () => void; t: (en: string, ar: string) => string;
  currency: (value: number) => string; user: User | null; setUser: (user: User | null) => void;
  cart: Cart; ready: boolean; loadingError: boolean; refreshCart: () => Promise<void>;
  updateCart: (id: string, quantity: number) => Promise<void>; addToCart: (id: string, quantity?: number) => Promise<void>;
  applyVoucher: (code: string) => Promise<void>; logout: () => Promise<void>;
  favorites: string[]; toggleFavorite: (id: string) => void; settings: StoreSettings;
};
const Store = createContext<StoreContext | null>(null);
const emptyCart: Cart = { items: [], subtotal: 0, shipping: 0, discount: 0, total: 0, voucherCode: "" };
export function StoreProvider({ children, initialLanguage, settings }: { children: ReactNode; initialLanguage: Language; settings: StoreSettings }) {
  const [language, setLanguage] = useState(initialLanguage);
  const [user, setUser] = useState<User | null>(null);
  const [cart, setCart] = useState<Cart>(emptyCart);
  const [ready, setReady] = useState(false);
  const [loadingError, setLoadingError] = useState(false);
  const favoritesRaw = useSyncExternalStore(subscribeFavorites, readFavorites, () => "[]");
  const favorites = parseFavorites(favoritesRaw);
  const cartRef = useRef(cart);
  const queue = useRef<Promise<unknown>>(Promise.resolve());
  const assignCart = (next: Cart) => { cartRef.current = next; setCart(next); };
  const t = (en: string, ar: string) => language === "ar" ? ar : en;
  const refreshCart = async () => { const data = await api<{ cart: Cart }>("cart"); assignCart(data.cart); };
  useEffect(() => {
    let active = true;
    Promise.all([api<{ user: User | null }>("auth/current"), api<{ cart: Cart }>("cart")]).then(([auth, data]) => { if (active) { setUser(auth.user); assignCart(data.cart); setLoadingError(false); } }).catch(() => { if (active) setLoadingError(true); }).finally(() => { if (active) setReady(true); });
    return () => { active = false; };
  }, []);
  const toggleLanguage = () => { const next = language === "en" ? "ar" : "en"; setLanguage(next); document.documentElement.lang = next; document.documentElement.dir = next === "ar" ? "rtl" : "ltr"; document.cookie = `oopsskin_language=${next};path=/;max-age=31536000;SameSite=Lax`; };
  const mutate = (fn: () => Promise<void>) => { const next = queue.current.then(fn, fn); queue.current = next.catch(() => {}); return next; };
  const updateCart = (id: string, quantity: number) => mutate(async () => { const result = await api<{ cart: Cart }>("cart", "PATCH", { productId: id, quantity }); assignCart(result.cart); });
  const addToCart = (id: string, quantity = 1) => mutate(async () => { const current = cartRef.current.items.find(i => i.productId === id)?.quantity || 0; const result = await api<{ cart: Cart }>("cart", "PATCH", { productId: id, quantity: current + quantity }); assignCart(result.cart); toast.success(t("Added to your bag", "ضفناه على سلتك")); });
  const applyVoucher = async (code: string) => { const result = await api<{ cart: Cart }>("cart/voucher", "POST", { code }); assignCart(result.cart); };
  const logout = async () => { await api("auth/logout", "POST", {}); setUser(null); await refreshCart(); };
  const toggleFavorite = (id: string) => {
    const previous = parseFavorites(readFavorites());
    const next = previous.includes(id) ? previous.filter(v => v !== id) : [...previous, id];
    try { localStorage.setItem("oopsskin_favorites", JSON.stringify(next)); window.dispatchEvent(new Event("oopsskin:favorites")); }
    catch { toast.error(t("Your browser could not save favorites.", "المتصفح ما قدر يحفظ المفضلة.")); }
  };
  const currency = (value: number) => new Intl.NumberFormat(language === "ar" ? "ar-PS" : "en-IL", { style: "currency", currency: "ILS", minimumFractionDigits: 0, maximumFractionDigits: 2 }).format(value);
  return <Store.Provider value={{ language, toggleLanguage, t, currency, user, setUser, cart, ready, loadingError, refreshCart, updateCart, addToCart, applyVoucher, logout, favorites, toggleFavorite, settings }}>{children}<Toaster richColors position="bottom-center" dir={language === "ar" ? "rtl" : "ltr"} /></Store.Provider>;
}
export function useStore() { const context = useContext(Store); if (!context) throw new Error("StoreProvider is missing"); return context; }

function readFavorites() { try { return localStorage.getItem("oopsskin_favorites") || "[]"; } catch { return "[]"; } }
function parseFavorites(raw: string): string[] { try { const value: unknown = JSON.parse(raw); return Array.isArray(value) ? value.filter((v): v is string => typeof v === "string") : []; } catch { return []; } }
function subscribeFavorites(callback: () => void) { window.addEventListener("storage",callback); window.addEventListener("oopsskin:favorites",callback); return () => { window.removeEventListener("storage",callback); window.removeEventListener("oopsskin:favorites",callback); }; }
