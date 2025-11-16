<script setup lang="js">
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const mobileMenuOpen = ref(false);
</script>

<template>
    <div class="min-h-screen bg-neutral-50">
        <!-- Navigation Header -->
        <header
            class="sticky top-0 z-50 border-b border-neutral-200 bg-white/95 backdrop-blur-sm"
        >
            <nav class="container mx-auto px-4 lg:px-8">
                <div class="flex h-20 items-center justify-between">
                    <!-- Logo -->
                    <Link href="/" class="flex items-center space-x-2">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-neutral-900 to-neutral-700"
                        >
                            <svg
                                class="h-6 w-6 text-white"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                                />
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span
                                class="text-xl font-bold tracking-tight text-neutral-900"
                                >Prestige</span
                            >
                            <span
                                class="text-xs tracking-wider text-neutral-500"
                                >IMMOBILIER</span
                            >
                        </div>
                    </Link>

                    <!-- Desktop Navigation -->
                    <div class="hidden items-center space-x-8 md:flex">
                        <Link
                            href="/"
                            class="text-sm font-medium text-neutral-700 transition-colors hover:text-neutral-900"
                        >
                            Nos Biens
                        </Link>
                        <Link
                            href="/dashboard"
                            class="text-sm font-medium text-neutral-700 transition-colors hover:text-neutral-900"
                        >
                            Espace Pro
                        </Link>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="rounded-lg p-2 text-neutral-700 hover:bg-neutral-100 md:hidden"
                    >
                        <svg
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                v-if="!mobileMenuOpen"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                            <path
                                v-else
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>

                <!-- Mobile Menu -->
                <div
                    v-if="mobileMenuOpen"
                    class="border-t border-neutral-200 py-4 md:hidden"
                >
                    <div class="flex flex-col space-y-3">
                        <Link
                            href="/"
                            class="rounded-lg px-4 py-2 text-sm font-medium text-neutral-700 hover:bg-neutral-50"
                        >
                            Nos Biens
                        </Link>
                        <Link
                            href="/dashboard"
                            class="rounded-lg px-4 py-2 text-sm font-medium text-neutral-700 hover:bg-neutral-50"
                        >
                            Espace Pro
                        </Link>
                        <Link
                            href="/login"
                            class="mx-4 rounded-full bg-neutral-900 px-6 py-2.5 text-center text-sm font-medium text-white"
                        >
                            Connexion
                        </Link>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Main Content -->
        <main>
            <slot />
        </main>

        <!-- Footer -->
        <footer class="mt-20 border-t border-neutral-200 bg-white">
            <div class="container mx-auto px-4 py-12 lg:px-8">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
                    <!-- Brand -->
                    <div class="col-span-1 md:col-span-2">
                        <div class="mb-4 flex items-center space-x-2">
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-neutral-900 to-neutral-700"
                            >
                                <svg
                                    class="h-6 w-6 text-white"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                                    />
                                </svg>
                            </div>
                            <div class="flex flex-col">
                                <span
                                    class="text-xl font-bold tracking-tight text-neutral-900"
                                    >Prestige</span
                                >
                                <span
                                    class="text-xs tracking-wider text-neutral-500"
                                    >IMMOBILIER</span
                                >
                            </div>
                        </div>
                        <p class="max-w-md text-sm text-neutral-600">
                            Votre partenaire de confiance pour l'achat et la
                            vente de biens d'exception en Belgique.
                        </p>
                    </div>

                    <!-- Links -->
                    <div>
                        <h3 class="mb-4 text-sm font-semibold text-neutral-900">
                            Navigation
                        </h3>
                        <ul class="space-y-2">
                            <li>
                                <Link
                                    href="/"
                                    class="text-sm text-neutral-600 hover:text-neutral-900"
                                    >Nos Biens</Link
                                >
                            </li>
                            <li>
                                <Link
                                    href="/dashboard"
                                    class="text-sm text-neutral-600 hover:text-neutral-900"
                                    >Espace Pro</Link
                                >
                            </li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div>
                        <h3 class="mb-4 text-sm font-semibold text-neutral-900">
                            Contact
                        </h3>
                        <ul class="space-y-2 text-sm text-neutral-600">
                            <li>contact@prestige-immo.be</li>
                            <li>+32 2 123 45 67</li>
                        </ul>
                    </div>
                </div>

                <div class="mt-12 border-t border-neutral-200 pt-8 text-center">
                    <p class="text-sm text-neutral-500">
                        © 2025 Prestige Immobilier. Tous droits réservés.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>
