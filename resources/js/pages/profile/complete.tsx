import CompleteProfileController from '@/actions/App/Http/Controllers/CompleteProfileController';
import InputError from '@/components/input-error';
import { MultiSelect } from '@/components/multi-select';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/app-layout';
import Combobox from '@/pages/profile/Combobox';
import { SharedData } from '@/types';
import { Transition } from '@headlessui/react';
import { Form, Head, usePage } from '@inertiajs/react';
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

const tags = [
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
    const [selectedFramework, setSelectedFramework] = useState('');
    const [selectedLanguages, setSelectedLanguages] = useState<string[]>([]);
    const [selectedTags, setSelectedTags] = useState<string[]>([]);
    const { auth } = usePage<SharedData>().props;

    return (
        <AppLayout>
            <Head title="Dashboard" />

            <div className="grid grid-cols-2 p-4">
                <Form
                    action={CompleteProfileController.update().url}
                    method={CompleteProfileController.update().method}
                    options={{
                        preserveScroll: true,
                    }}
                    transform={(data) => ({
                        ...data,
                        selectedFramework,
                        selectedLanguages,
                        selectedTags,
                    })}
                    className="space-y-6"
                >
                    {({ errors, processing, recentlySuccessful }) => {
                        console.log('errors', errors);
                        return (
                            <>
                                <div className="grid gap-2">
                                    <Label htmlFor="name">Name</Label>

                                    <Input
                                        id="name"
                                        className="mt-1 block w-full"
                                        defaultValue={auth.user.name}
                                        name="name"
                                        autoComplete="name"
                                        placeholder="Full name"
                                    />

                                    <InputError
                                        className="mt-2"
                                        message={errors.name}
                                    />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="email">Email address</Label>

                                    <Input
                                        id="email"
                                        type="email"
                                        className="mt-1 block w-full"
                                        defaultValue={auth.user.email}
                                        name="email"
                                        required
                                        autoComplete="username"
                                        placeholder="Email address"
                                    />

                                    <InputError
                                        className="mt-2"
                                        message={errors.email}
                                    />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="bio">
                                        Bio{' '}
                                        <span className="text-gray-500">
                                            (optional)
                                        </span>
                                    </Label>

                                    <Textarea name="bio"></Textarea>

                                    <InputError className="mt-2" message={''} />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="country">Country</Label>

                                    <Combobox
                                        data={frameworks}
                                        label="framework"
                                        value={selectedFramework}
                                        setValue={setSelectedFramework}
                                    />

                                    <InputError className="mt-2" message={''} />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="languages">
                                        Spoken languages
                                    </Label>

                                    <MultiSelect
                                        options={languages}
                                        value={selectedLanguages}
                                        onValueChange={setSelectedLanguages}
                                        placeholder="Choose frameworks..."
                                    />

                                    <InputError className="mt-2" message={''} />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="languages">
                                        Specialities
                                    </Label>

                                    <MultiSelect
                                        options={tags}
                                        value={selectedTags}
                                        onValueChange={setSelectedTags}
                                        placeholder="Choose tags..."
                                    />

                                    <InputError className="mt-2" message={''} />
                                </div>

                                <div className="flex items-center gap-4">
                                    <Button
                                        disabled={processing}
                                        data-test="update-profile-button"
                                        className="cursor-pointer"
                                    >
                                        Save
                                    </Button>

                                    <Transition
                                        show={recentlySuccessful}
                                        enter="transition ease-in-out"
                                        enterFrom="opacity-0"
                                        leave="transition ease-in-out"
                                        leaveTo="opacity-0"
                                    >
                                        <p className="text-sm text-neutral-600">
                                            Saved
                                        </p>
                                    </Transition>
                                </div>
                            </>
                        );
                    }}
                </Form>
            </div>
        </AppLayout>
    );
};

export default Complete;
