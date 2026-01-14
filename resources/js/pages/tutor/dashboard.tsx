import { edit } from '@/actions/App/Http/Controllers/CompleteProfileController';
import { update } from '@/actions/App/Http/Controllers/Tutor/BookingController';
import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes/tutor';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/react';
import { Calendar, CheckCircle, Clock } from 'lucide-react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

interface Booking {
    id: number;
    start: string;
    end: string;
    status: string;
    student: {
        user: {
            name: string;
            email: string;
        };
    };
}

interface Props {
    stats: {
        total_sessions: number;
        pending_requests: number;
        upcoming_sessions: number;
    };
    upcomingBookings: Booking[];
    pendingBookings: Booking[];
}

export default function Dashboard({
    stats,
    upcomingBookings,
    pendingBookings,
}: Props) {
    const { patch, processing } = useForm();

    const handleStatusUpdate = (
        id: number,
        status: 'confirmed' | 'rejected',
    ) => {
        patch(update(id).url, {
            data: { status },
        });
    };

    const formatDate = (dateString: string) => {
        return new Date(dateString).toLocaleDateString('en-US', {
            weekday: 'short',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Tutor Dashboard" />

            <div className="flex flex-1 flex-col gap-4 p-4 pt-0">
                <div className="grid gap-4 md:grid-cols-3">
                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">
                                Total Sessions
                            </CardTitle>
                            <CheckCircle className="h-4 w-4 text-muted-foreground" />
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold">
                                {stats.total_sessions}
                            </div>
                        </CardContent>
                    </Card>
                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">
                                Pending Requests
                            </CardTitle>
                            <Clock className="h-4 w-4 text-muted-foreground" />
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold">
                                {stats.pending_requests}
                            </div>
                        </CardContent>
                    </Card>
                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">
                                Upcoming Sessions
                            </CardTitle>
                            <Calendar className="h-4 w-4 text-muted-foreground" />
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold">
                                {stats.upcoming_sessions}
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-7">
                    <Card className="col-span-4">
                        <CardHeader>
                            <CardTitle>Upcoming Sessions</CardTitle>
                            <CardDescription>
                                You have {upcomingBookings.length} sessions
                                coming up.
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-8">
                                {upcomingBookings.length === 0 ? (
                                    <p className="text-sm text-muted-foreground">
                                        No upcoming sessions.
                                    </p>
                                ) : (
                                    upcomingBookings.map((booking) => (
                                        <div
                                            key={booking.id}
                                            className="flex items-center"
                                        >
                                            <Avatar className="h-9 w-9">
                                                <AvatarFallback>
                                                    {booking.student.user.name.charAt(
                                                        0,
                                                    )}
                                                </AvatarFallback>
                                            </Avatar>
                                            <div className="ml-4 space-y-1">
                                                <p className="text-sm leading-none font-medium">
                                                    {booking.student.user.name}
                                                </p>
                                                <p className="text-sm text-muted-foreground">
                                                    {formatDate(booking.start)}
                                                </p>
                                            </div>
                                            <div className="ml-auto font-medium">
                                                <Badge variant="outline">
                                                    Confirmed
                                                </Badge>
                                            </div>
                                        </div>
                                    ))
                                )}
                            </div>
                        </CardContent>
                    </Card>

                    <Card className="col-span-3">
                        <CardHeader>
                            <CardTitle>Pending Requests</CardTitle>
                            <CardDescription>
                                Approve or reject new booking requests.
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-8">
                                {pendingBookings.length === 0 ? (
                                    <p className="text-sm text-muted-foreground">
                                        No pending requests.
                                    </p>
                                ) : (
                                    pendingBookings.map((booking) => (
                                        <div
                                            key={booking.id}
                                            className="flex items-center"
                                        >
                                            <div className="space-y-1">
                                                <p className="text-sm leading-none font-medium">
                                                    {booking.student.user.name}
                                                </p>
                                                <p className="text-xs text-muted-foreground">
                                                    {formatDate(booking.start)}
                                                </p>
                                            </div>
                                            <div className="ml-auto flex gap-2">
                                                <Button
                                                    size="sm"
                                                    variant="outline"
                                                    className="h-8"
                                                    disabled={processing}
                                                    onClick={() =>
                                                        handleStatusUpdate(
                                                            booking.id,
                                                            'rejected',
                                                        )
                                                    }
                                                >
                                                    Reject
                                                </Button>
                                                <Button
                                                    size="sm"
                                                    className="h-8"
                                                    disabled={processing}
                                                    onClick={() =>
                                                        handleStatusUpdate(
                                                            booking.id,
                                                            'confirmed',
                                                        )
                                                    }
                                                >
                                                    Approve
                                                </Button>
                                            </div>
                                        </div>
                                    ))
                                )}
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <div className="mt-4">
                    <Button variant="secondary" asChild>
                        <Link href={edit().url}>Complete your profile</Link>
                    </Button>
                </div>
            </div>
        </AppLayout>
    );
}
