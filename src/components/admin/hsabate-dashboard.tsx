"use client";
import { useEffect, useState } from 'react';
import { RefreshCw, Activity } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { api, errorMessage } from '@/lib/client';
import { useStore } from '@/components/store/provider';

type Summary = { received: number; active: number; inserted: number; updated: number; archived: number; durationMs: number; finishedAt: string };
type Status = { locked: boolean; endpoint: string; configured: boolean; total: number; active: number; state: { status: string; lockedUntil: string; error?: string; lastSuccess?: Summary; history?: Summary[] } | null };
export function HsabateDashboard({ onSynced }: { onSynced: () => Promise<void> }) {
  const { t } = useStore();
  const [status, setStatus] = useState<Status | null>(null);
  const [busy, setBusy] = useState('');
  const [error, setError] = useState('');
  const [debug, setDebug] = useState<unknown>(null);
  const [result, setResult] = useState<Summary | null>(null);
  const refresh = async () => setStatus(await api<Status>('admin/hsabate'));
  useEffect(() => { void api<Status>('admin/hsabate').then(setStatus).catch(e => setError(errorMessage(e))); }, []);
  const run = async (action: 'debug' | 'sync') => {
    setBusy(action); setError(''); setResult(null);
    try {
      if (action === 'debug') setDebug(await api('admin/hsabate/debug', 'POST'));
      else { setResult(await api<Summary>('admin/hsabate/sync', 'POST')); await onSynced(); }
    } catch (e) { setError(errorMessage(e)); }
    finally { try { await refresh(); } catch (e) { setError(errorMessage(e)); } setBusy(''); }
  };
  const locked = status?.locked;
  return <div className="space-y-6">
    <div className="soft-panel space-y-4"><h2 className="text-xl font-semibold">{t('Hsabate product sync', 'مزامنة منتجات حسابات')}</h2>
      <p className="text-sm text-muted-foreground">{t('Edit products in Hsabate, then sync here. All API items are stored; only e-commerce items appear in the shop. Local order reservations are kept. Previous local products are archived after a successful sync.', 'عدّلي المنتجات في حسابات ثم زامني هنا. تُحفظ جميع المنتجات وتظهر منتجات التجارة الإلكترونية فقط في المتجر. تُحفظ حجوزات الطلبات المحلية وتُؤرشف المنتجات المحلية السابقة بعد نجاح المزامنة.')}</p>
      <p className="break-all font-mono text-xs">{status?.endpoint || 'https://s.hesabate.com/store_api.php'}</p>
      <p className="text-sm">{t('Credentials', 'بيانات الاتصال')}: {status ? (status.configured ? t('Configured', 'مضبوطة') : t('Missing', 'غير متوفرة')) : t('Loading…', 'جاري التحميل…')}</p>
      <div className="flex flex-wrap gap-3"><Button disabled={!!busy || !status?.configured || locked} onClick={() => run('sync')}><RefreshCw className={busy === 'sync' ? 'size-4 animate-spin' : 'size-4'} />{t(busy === 'sync' ? 'Syncing…' : 'Sync products now', busy === 'sync' ? 'جاري المزامنة…' : 'مزامنة المنتجات الآن')}</Button><Button variant="outline" disabled={!!busy || !status?.configured || locked} onClick={() => run('debug')}><Activity className="size-4" />{t(busy === 'debug' ? 'Testing…' : 'Test API', busy === 'debug' ? 'جاري الاختبار…' : 'اختبار API')}</Button><Button variant="ghost" disabled={!!busy} onClick={() => { void refresh().catch(e => setError(errorMessage(e))); }}>{t('Refresh status', 'تحديث الحالة')}</Button></div>
      {locked && <p role="status">{t('A sync is running. Refresh status to check progress.', 'المزامنة قيد التشغيل. حدّثي الحالة لمتابعتها.')}</p>}
    </div>
    {(error || status?.state?.error) && <p role="alert" className="rounded-xl border border-destructive p-4 text-sm text-destructive">{error || status?.state?.error}</p>}
    {result && <p role="status" className="soft-panel">{t('Sync completed', 'اكتملت المزامنة')}: {result.inserted} {t('added', 'أُضيفت')} · {result.updated} {t('updated', 'حُدّثت')} · {result.archived} {t('archived', 'أُرشفت')}</p>}
    <div className="grid gap-4 sm:grid-cols-3">{[[t('API products in database', 'منتجات API في قاعدة البيانات'), status?.total ?? '—'], [t('Visible in shop', 'ظاهرة في المتجر'), status?.active ?? '—'], [t('Last successful sync', 'آخر مزامنة ناجحة'), status?.state?.lastSuccess ? new Date(status.state.lastSuccess.finishedAt).toLocaleString() : t('Never', 'لم تتم بعد')]].map(([label, value]) => <div key={label} className="soft-panel"><p className="mb-3 text-sm text-muted-foreground">{label}</p><p className="font-semibold">{value}</p></div>)}</div>
    {!!status?.state?.history?.length && <div className="soft-panel overflow-x-auto"><h3 className="mb-4 font-semibold">{t('Recent syncs', 'آخر عمليات المزامنة')}</h3><table className="w-full text-start text-sm"><thead><tr>{['Time', 'Received', 'Added', 'Updated', 'Archived'].map(h => <th key={h} className="p-2 text-start">{h}</th>)}</tr></thead><tbody>{[...status.state.history].reverse().map((row, i) => <tr key={i} className="border-t"><td className="p-2">{new Date(row.finishedAt).toLocaleString()}</td>{[row.received, row.inserted, row.updated, row.archived].map((n, j) => <td key={j} className="p-2">{n}</td>)}</tr>)}</tbody></table></div>}
    {debug !== null && <details open className="soft-panel"><summary className="cursor-pointer font-semibold">{t('API debug response', 'نتيجة اختبار API')}</summary><pre dir="ltr" className="mt-4 max-h-120 overflow-auto whitespace-pre-wrap break-all text-xs">{JSON.stringify(debug, null, 2)}</pre></details>}
  </div>;
}
