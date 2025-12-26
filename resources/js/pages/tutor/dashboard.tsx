import { edit } from '@/actions/App/Http/Controllers/CompleteProfileController';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes/tutor';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

export default function Dashboard() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="p-4">
                <Button className="cursor-pointer">
                    <Link href={edit()}>Complete your profile</Link>
                </Button>
            </div>
        </AppLayout>
    );
}
