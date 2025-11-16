<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { index, show, create } from '@/actions/App/Http/Controllers/HouseController';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';

const props = defineProps<{
    stats: {
        houses_count: number;
        total_value: number;
        average_price: number;
    };
    recent_houses: any[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

const formatPrice = (price: number) => {
    return new Intl.NumberFormat('fr-FR', {
        style: 'currency',
        currency: 'EUR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    }).format(price);
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <!-- Header -->
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">Dashboard</h1>
                    <p class="text-muted-foreground">
                        Bienvenue sur votre tableau de bord
                    </p>
                </div>
                <Button @click="$inertia.visit(create())">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="mr-2 h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 4v16m8-8H4"
                        />
                    </svg>
                    Ajouter une maison
                </Button>
            </div>

            <!-- Statistiques -->
            <div class="grid gap-4 md:grid-cols-3">
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">
                            Biens immobiliers
                        </CardTitle>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 text-muted-foreground"
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
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ stats.houses_count }}</div>
                        <p class="text-xs text-muted-foreground">
                            maison{{ stats.houses_count > 1 ? 's' : '' }} enregistrée{{ stats.houses_count > 1 ? 's' : '' }}
                        </p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">
                            Valeur totale
                        </CardTitle>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 text-muted-foreground"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ formatPrice(stats.total_value) }}</div>
                        <p class="text-xs text-muted-foreground">
                            du portefeuille immobilier
                        </p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">
                            Prix moyen
                        </CardTitle>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 text-muted-foreground"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                            />
                        </svg>
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ formatPrice(stats.average_price) }}</div>
                        <p class="text-xs text-muted-foreground">
                            par bien immobilier
                        </p>
                    </CardContent>
                </Card>
            </div>

            <!-- Maisons récentes -->
            <Card v-if="recent_houses.length > 0">
                <CardHeader>
                    <div class="flex items-center justify-between">
                        <div>
                            <CardTitle>Biens récents</CardTitle>
                            <CardDescription>Vos dernières maisons ajoutées</CardDescription>
                        </div>
                        <Button variant="outline" size="sm" @click="$inertia.visit(index())">
                            Voir tout
                        </Button>
                    </div>
                </CardHeader>
                <CardContent>
                    <div class="grid gap-4 md:grid-cols-3">
                        <Card
                            v-for="house in recent_houses"
                            :key="house.id"
                            class="overflow-hidden cursor-pointer transition-shadow hover:shadow-lg"
                            @click="$inertia.visit(show(house.id))"
                        >
                            <!-- Image principale -->
                            <div class="aspect-video bg-muted">
                                <img
                                    v-if="house.images && house.images.length > 0"
                                    :src="house.images[0].url"
                                    :alt="house.title"
                                    class="h-full w-full object-cover"
                                />
                                <div
                                    v-else
                                    class="flex h-full items-center justify-center"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-12 w-12 text-muted-foreground"
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
                            </div>

                            <CardContent class="p-4">
                                <div class="space-y-2">
                                    <h3 class="font-semibold line-clamp-1">{{ house.title }}</h3>
                                    <p class="text-sm text-muted-foreground line-clamp-1">
                                        {{ house.address }}
                                    </p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-lg font-bold text-primary">
                                            {{ formatPrice(house.price) }}
                                        </span>
                                        <div class="flex gap-1">
                                            <Badge variant="secondary" class="text-xs">
                                                {{ house.bedrooms }} ch.
                                            </Badge>
                                            <Badge variant="secondary" class="text-xs">
                                                {{ house.size }} m²
                                            </Badge>
                                        </div>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                    </div>
                </CardContent>
            </Card>

            <!-- Empty state -->
            <Card v-else>
                <CardContent class="flex flex-col items-center justify-center py-16">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="mb-4 h-24 w-24 text-muted-foreground"
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
                    <h3 class="mb-2 text-xl font-semibold">Aucune maison</h3>
                    <p class="mb-4 text-muted-foreground">
                        Commencez par ajouter votre première maison
                    </p>
                    <Button @click="$inertia.visit(create())">
                        Ajouter une maison
                    </Button>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
