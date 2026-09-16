export const CITIES = ["جنين","طوباس","نابلس","سلفيت","طولكرم","قلقيلية","رام الله والبيرة","ضواحي القدس","اريحا","الخليل","بيت لحم","القدس","الداخل 48"] as const;
export type City = (typeof CITIES)[number];
export const isCity = (value: string): value is City => (CITIES as readonly string[]).includes(value);
