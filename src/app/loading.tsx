import { Skeleton } from "@/components/ui/skeleton";
export default function Loading() { return <div className="page-container py-16" role="status" aria-label="Loading / جاري التحميل"><Skeleton className="mx-auto mb-10 h-12 w-1/2" /><div className="grid grid-cols-2 gap-5 lg:grid-cols-4">{[1,2,3,4].map(i=><Skeleton key={i} className="aspect-[4/5] w-full" />)}</div></div>; }
