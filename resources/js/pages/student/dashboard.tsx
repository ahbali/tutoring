import AppLayout from '@/layouts/app-layout';
import TutorCard from '@/pages/student/tutor-card';
import { dashboard } from '@/routes/student';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import '/node_modules/flag-icons/css/flag-icons.min.css';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

export default function Dashboard({
    tutors,
}: {
    tutors: {
        name: string;
        user: { name: string; image: string };
        country: { code: string };
    }[];
}) {
    console.log(tutors);

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="p-4">
                <div className="grid grid-cols-3 gap-8">
                    {tutors.map((tutor, index) => (
                        <TutorCard
                            key={index}
                            name={tutor.user.name}
                            country_code={tutor.country.code.toLowerCase()}
                            speciality="Mathematics"
                            reviews={120}
                            rating={4.9}
                            lessons={300}
                            image={tutor.user.image}
                        />
                    ))}
                </div>
            </div>
        </AppLayout>
    );
}
