<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { mask } from 'vue-the-mask';

import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    profile: '',
    cpf: '',
    active: 'S',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

const onlyNumbers = (event) => {
    const char = String.fromCharCode(event.which);
    if (!/[0-9]/.test(char)) {
        event.preventDefault();
    }
};

const vMask = mask;
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    value="Confirm Password"
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="mt-4">
                <InputLabel for="cpf" value="CPF" />

                <TextInput
                    id="cpf"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.cpf"
                    v-mask="'###.###.###-##'"
                    required
                    autocomplete="cpf"
                    @keypress="onlyNumbers"
                />

                <InputError class="mt-2" :message="form.errors.cpf" />
            </div>

            <div class="mt-4">
                <InputLabel for="profile" value="Profile" />

                <select
                    id="profile"
                    class="mt-1 block w-full"
                    v-model="form.profile"
                    required
                >
                    <option value="" disabled>Selecione o perfil</option>
                    <option value="T">Administrador da TI</option>
                    <option value="S">Administrador do Sistema</option>
                    <option value="A">Atendente</option>
                </select>

                <InputError class="mt-2" :message="form.errors.profile" />
            </div>

            <div class="mt-4">
                <InputLabel for="active" value="Ativo" />

                <select
                    id="ativo"
                    class="mt-1 block w-full"
                    v-model="form.active"
                    required
                >
                    <option value="S">Ativo</option>
                    <option value="N">Desativado</option>
                </select>

                <InputError class="mt-2" :message="form.errors.active" />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Link
                    :href="route('login')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Already registered?
                </Link>

                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
