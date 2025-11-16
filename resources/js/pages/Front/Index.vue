<script setup lang="js">
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import FrontLayout from '@/layouts/FrontLayout.vue';

const props = defineProps({
    houses: Object,
    houseTypes: Array,
    filters: Object,
    heroImage: String,
});

// Filters state
const search = ref(props.filters.search || '');
const priceMin = ref(props.filters.price_min || '');
const priceMax = ref(props.filters.price_max || '');
const bedrooms = ref(props.filters.bedrooms || '');
const houseTypeId = ref(props.filters.house_type_id || '');

// Apply filters with debounce
let timeout = null;
const applyFilters = () => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        router.get(
            '/',
            {
                search: search.value || undefined,
                price_min: priceMin.value || undefined,
                price_max: priceMax.value || undefined,
                bedrooms: bedrooms.value || undefined,
                house_type_id: houseTypeId.value || undefined,
            },
            {
                preserveState: true,
                preserveScroll: true,
            }
        );
    }, 500);
};

watch([search, priceMin, priceMax, bedrooms, houseTypeId], applyFilters);

const formatPrice = (price) => {
    return new Intl.NumberFormat('fr-BE', {
        style: 'currency',
        currency: 'EUR',
        maximumFractionDigits: 0,
    }).format(price);
};
</script>

<template>
    <FrontLayout>
        <!-- Hero Section -->
        <section class="relative overflow-hidden bg-neutral-900 py-24 lg:py-32">
            <!-- Hero Image Background -->
            <div v-if="heroImage" class="absolute inset-0">
                <img
                    :src="heroImage"
                    alt="Hero background"
                    class="h-full w-full object-cover"
                />
                <!-- Blur + Dark Overlay -->
                <div class="absolute inset-0 bg-neutral-900/75 backdrop-blur-sm"></div>
            </div>

            <!-- Fallback gradient si pas d'image -->
            <div v-else class="absolute inset-0 bg-gradient-to-br from-neutral-900 via-neutral-800 to-neutral-900"></div>

            <!-- Pattern overlay subtil -->
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0zNiAxOGMzLjMxNCAwIDYgMi42ODYgNiA2cy0yLjY4NiA2LTYgNi02LTIuNjg2LTYtNiAyLjY4Ni02IDYtNiIgc3Ryb2tlPSIjZmZmIiBzdHJva2Utb3BhY2l0eT0iLjA1IiBzdHJva2Utd2lkdGg9IjIiLz48L2c+PC9zdmc+')] opacity-10"></div>

            <div class="container relative mx-auto px-4 lg:px-8">
                <div class="mx-auto max-w-3xl text-center">
                    <h1 class="text-5xl font-bold tracking-tight text-white sm:text-6xl lg:text-7xl">
                        Trouvez votre
                        <span class="bg-gradient-to-r from-amber-200 to-yellow-400 bg-clip-text text-transparent">
                            bien d'exception
                        </span>
                    </h1>
                    <p class="mt-6 text-lg leading-8 text-neutral-300">
                        Découvrez notre sélection exclusive de propriétés de prestige en Belgique.
                    </p>

                    <!-- Search Bar -->
                    <div class="mt-10 flex justify-center">
                        <div class="w-full max-w-2xl">
                            <div class="relative">
                                <input
                                    v-model="search"
                                    type="text"
                                    placeholder="Rechercher par ville, adresse..."
                                    class="w-full rounded-full bg-white px-6 py-4 pl-14 text-neutral-900 shadow-2xl ring-1 ring-white/10 placeholder:text-neutral-400 focus:outline-none focus:ring-2 focus:ring-amber-400"
                                />
                                <svg class="absolute left-5 top-1/2 h-5 w-5 -translate-y-1/2 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Filters Section -->
        <section class="border-b border-neutral-200 bg-white py-6">
            <div class="container mx-auto px-4 lg:px-8">
                <div class="grid grid-cols-2 gap-4 lg:grid-cols-5">
                    <!-- Type -->
                    <div>
                        <label class="mb-2 block text-xs font-medium text-neutral-700">Type de bien</label>
                        <select
                            v-model="houseTypeId"
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-neutral-900 transition-colors focus:border-neutral-900 focus:outline-none focus:ring-1 focus:ring-neutral-900"
                        >
                            <option value="">Tous</option>
                            <option v-for="type in houseTypes" :key="type.id" :value="type.id">
                                {{ type.name }}
                            </option>
                        </select>
                    </div>

                    <!-- Price Min -->
                    <div>
                        <label class="mb-2 block text-xs font-medium text-neutral-700">Prix min</label>
                        <input
                            v-model="priceMin"
                            type="number"
                            placeholder="0 €"
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-neutral-900 transition-colors focus:border-neutral-900 focus:outline-none focus:ring-1 focus:ring-neutral-900"
                        />
                    </div>

                    <!-- Price Max -->
                    <div>
                        <label class="mb-2 block text-xs font-medium text-neutral-700">Prix max</label>
                        <input
                            v-model="priceMax"
                            type="number"
                            placeholder="∞"
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-neutral-900 transition-colors focus:border-neutral-900 focus:outline-none focus:ring-1 focus:ring-neutral-900"
                        />
                    </div>

                    <!-- Bedrooms -->
                    <div>
                        <label class="mb-2 block text-xs font-medium text-neutral-700">Chambres min</label>
                        <select
                            v-model="bedrooms"
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-neutral-900 transition-colors focus:border-neutral-900 focus:outline-none focus:ring-1 focus:ring-neutral-900"
                        >
                            <option value="">Toutes</option>
                            <option value="1">1+</option>
                            <option value="2">2+</option>
                            <option value="3">3+</option>
                            <option value="4">4+</option>
                            <option value="5">5+</option>
                        </select>
                    </div>

                    <!-- Reset -->
                    <div class="flex items-end">
                        <button
                            @click="search = ''; priceMin = ''; priceMax = ''; bedrooms = ''; houseTypeId = ''"
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm font-medium text-neutral-700 transition-colors hover:bg-neutral-50"
                        >
                            Réinitialiser
                        </button>
                    </div>
                </div>

                <!-- Results Count -->
                <div class="mt-4 text-sm text-neutral-600">
                    {{ houses.total }} bien{{ houses.total > 1 ? 's' : '' }} trouvé{{ houses.total > 1 ? 's' : '' }}
                </div>
            </div>
        </section>

        <!-- Houses Grid -->
        <section class="py-12 lg:py-16">
            <div class="container mx-auto px-4 lg:px-8">
                <div v-if="houses.data.length > 0" class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <a
                        v-for="house in houses.data"
                        :key="house.id"
                        :href="`/biens/${house.id}`"
                        class="group overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-neutral-200 transition-all hover:shadow-xl hover:ring-neutral-300"
                    >
                        <!-- Image -->
                        <div class="relative aspect-[4/3] overflow-hidden bg-neutral-100">
                            <img
                                v-if="house.images && house.images.length > 0"
                                :src="house.images[0].url"
                                :alt="house.title"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                            />
                            <div v-else class="flex h-full w-full items-center justify-center">
                                <svg class="h-16 w-16 text-neutral-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>

                            <!-- Type Badge -->
                            <div v-if="house.houseType" class="absolute left-4 top-4">
                                <span class="rounded-full bg-white/95 px-3 py-1 text-xs font-medium text-neutral-900 shadow-lg backdrop-blur-sm">
                                    {{ house.houseType.name }}
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <!-- Price -->
                            <div class="mb-2">
                                <span class="text-2xl font-bold text-neutral-900">
                                    {{ formatPrice(house.price) }}
                                </span>
                            </div>

                            <!-- Title -->
                            <h3 class="mb-2 text-lg font-semibold text-neutral-900 line-clamp-1">
                                {{ house.title }}
                            </h3>

                            <!-- Address -->
                            <p class="mb-4 flex items-center text-sm text-neutral-600">
                                <svg class="mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ house.address }}
                            </p>

                            <!-- Features -->
                            <div class="flex items-center space-x-4 border-t border-neutral-100 pt-4 text-sm text-neutral-600">
                                <div class="flex items-center">
                                    <svg class="mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    <span class="font-medium">{{ house.bedrooms }}</span>
                                    <span class="ml-1">ch.</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                                    </svg>
                                    <span class="font-medium">{{ house.size }}</span>
                                    <span class="ml-1">m²</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Empty State -->
                <div v-else class="py-20 text-center">
                    <svg class="mx-auto h-16 w-16 text-neutral-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-neutral-900">Aucun bien trouvé</h3>
                    <p class="mt-2 text-sm text-neutral-600">
                        Essayez de modifier vos critères de recherche.
                    </p>
                </div>

                <!-- Pagination -->
                <div v-if="houses.data.length > 0 && houses.last_page > 1" class="mt-12 flex justify-center">
                    <nav class="flex items-center space-x-2">
                        <a
                            v-for="link in houses.links"
                            :key="link.label"
                            :href="link.url"
                            :class="[
                                'rounded-lg px-4 py-2 text-sm font-medium transition-colors',
                                link.active
                                    ? 'bg-neutral-900 text-white'
                                    : link.url
                                    ? 'bg-white text-neutral-700 ring-1 ring-neutral-200 hover:bg-neutral-50'
                                    : 'bg-white text-neutral-400 ring-1 ring-neutral-200 cursor-not-allowed',
                            ]"
                        >
                            <span v-if="link.label.includes('Previous')">←</span>
                            <span v-else-if="link.label.includes('Next')">→</span>
                            <span v-else>{{ link.label }}</span>
                        </a>
                    </nav>
                </div>
            </div>
        </section>
    </FrontLayout>
</template>
