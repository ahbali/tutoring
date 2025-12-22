import InputError from '@/components/input-error';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/app-layout';
import Combobox from '@/pages/profile/Combobox';
import { Form, Head } from '@inertiajs/react';
import { useState } from 'react';

const frameworks = [
    {
        value: 'next.js',
        label: 'Next.js',
    },
    {
        value: 'sveltekit',
        label: 'SvelteKit',
    },
    {
        value: 'nuxt.js',
        label: 'Nuxt.js',
    },
    {
        value: 'remix',
        label: 'Remix',
    },
    {
        value: 'astro',
        label: 'Astro',
    },
];

const languages = [
    {
        value: 'english',
        label: 'English',
    },
    {
        value: 'arabic',
        label: 'Arabic',
    },
];

const Complete = () => {
    const [framework, setFramework] = useState('');
    const [language, setLanguage] = useState('');

    return (
        <AppLayout>
            <Head title="Dashboard" />

            <div className="grid grid-cols-2 p-4">
                <Form
                    options={{
                        preserveScroll: true,
                    }}
                    className="space-y-6"
                >
                    <div className="grid gap-2">
                        <Label htmlFor="name">Name</Label>

                        <Input
                            id="name"
                            className="mt-1 block w-full"
                            defaultValue={''}
                            name="name"
                            required
                            autoComplete="name"
                            placeholder="Full name"
                        />

                        <InputError className="mt-2" message={''} />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="name">Name</Label>

                        <Combobox
                            data={frameworks}
                            label="framework"
                            value={framework}
                            setValue={setFramework}
                        />

                        <Combobox
                            data={languages}
                            label="language"
                            value={language}
                            setValue={setLanguage}
                        />

                        <InputError className="mt-2" message={''} />
                    </div>
                </Form>
            </div>
        </AppLayout>
    );
};

export default Complete;
