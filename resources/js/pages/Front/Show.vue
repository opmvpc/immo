<script setup>
import { ref } from 'vue';
import FrontLayout from '@/layouts/FrontLayout.vue';

const props = defineProps({
    house: Object,
    similarHouses: Array,
});

const currentImageIndex = ref(0);

const formatPrice = (price) => {
    return new Intl.NumberFormat('fr-BE', {
        style: 'currency',
        currency: 'EUR',
        maximumFractionDigits: 0,
    }).format(price);
};

const nextImage = () => {
    if (currentImageIndex.value < props.house.images.length - 1) {
        currentImageIndex.value++;
    } else {
        currentImageIndex.value = 0;
    }
};

const prevImage = () => {
    if (currentImageIndex.value > 0) {
        currentImageIndex.value--;
    } else {
        currentImageIndex.value = props.house.images.length - 1;
    }
};
</script>

<template>
    <FrontLayout>
        <!-- Breadcrumb -->
        <section class="border-b border-neutral-200 bg-white py-4">
            <div class="container mx-auto px-4 lg:px-8">
                <nav class="flex items-center space-x-2 text-sm text-neutral-600">
                    <a href="/" class="hover:text-neutral-900">Accueil</a>
                    <span>/</span>
                    <span class="text-neutral-900">{{ house.title }}</span>
                </nav>
            </div>
        </section>

        <!-- Main Content -->
        <section class="py-8 lg:py-12">
            <div class="container mx-auto px-4 lg:px-8">
                <div class="grid gap-8 lg:grid-cols-3">
                    <!-- Left Column - Images & Details -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Image Gallery -->
                        <div class="overflow-hidden rounded-2xl bg-neutral-100">
                            <div v-if="house.images && house.images.length > 0" class="relative">
                                <!-- Main Image -->
                                <div class="relative aspect-[16/10] overflow-hidden">
                                    <img
                                        :src="house.images[currentImageIndex].url"
                                        :alt="house.title"
                                        class="h-full w-full object-cover"
                                    />

                                    <!-- Navigation Arrows -->
                                    <button
                                        v-if="house.images.length > 1"
                                        @click="prevImage"
                                        class="absolute left-4 top-1/2 -translate-y-1/2 flex h-10 w-10 items-center justify-center rounded-full bg-white/90 text-neutral-900 shadow-lg backdrop-blur-sm transition-all hover:bg-white hover:scale-110"
                                    >
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </button>
                                    <button
                                        v-if="house.images.length > 1"
                                        @click="nextImage"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 flex h-10 w-10 items-center justify-center rounded-full bg-white/90 text-neutral-900 shadow-lg backdrop-blur-sm transition-all hover:bg-white hover:scale-110"
                                    >
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>

                                    <!-- Image Counter -->
                                    <div class="absolute bottom-4 right-4 rounded-full bg-neutral-900/80 px-3 py-1.5 text-sm text-white backdrop-blur-sm">
                                        {{ currentImageIndex + 1 }} / {{ house.images.length }}
                                    </div>
                                </div>

                                <!-- Thumbnails -->
                                <div v-if="house.images.length > 1" class="flex gap-2 overflow-x-auto p-4">
                                    <button
                                        v-for="(image, index) in house.images"
                                        :key="image.id"
                                        @click="currentImageIndex = index"
                                        :class="[
                                            'relative h-20 w-20 flex-shrink-0 overflow-hidden rounded-lg transition-all',
                                            currentImageIndex === index
                                                ? 'ring-2 ring-neutral-900 ring-offset-2'
                                                : 'opacity-60 hover:opacity-100',
                                        ]"
                                    >
                                        <img
                                            :src="image.url"
                                            :alt="`${house.title} - Image ${index + 1}`"
                                            class="h-full w-full object-cover"
                                        />
                                    </button>
                                </div>
                            </div>
                            <div v-else class="flex aspect-[16/10] items-center justify-center">
                                <svg class="h-24 w-24 text-neutral-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-neutral-200">
                            <h2 class="mb-4 text-2xl font-bold text-neutral-900">Description</h2>
                            <p class="whitespace-pre-line text-neutral-700 leading-relaxed">
                                {{ house.description || 'Aucune description disponible.' }}
                            </p>
                        </div>

                        <!-- Features Grid -->
                        <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-neutral-200">
                            <h2 class="mb-6 text-2xl font-bold text-neutral-900">Caractéristiques</h2>
                            <div class="grid grid-cols-2 gap-6 sm:grid-cols-3">
                                <div class="flex items-start space-x-3">
                                    <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-neutral-100">
                                        <svg class="h-5 w-5 text-neutral-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm text-neutral-600">Chambres</div>
                                        <div class="text-lg font-semibold text-neutral-900">{{ house.bedrooms }}</div>
                                    </div>
                                </div>

                                <div class="flex items-start space-x-3">
                                    <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-neutral-100">
                                        <svg class="h-5 w-5 text-neutral-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm text-neutral-600">Surface</div>
                                        <div class="text-lg font-semibold text-neutral-900">{{ house.size }} m²</div>
                                    </div>
                                </div>

                                <div v-if="house.houseType" class="flex items-start space-x-3">
                                    <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-neutral-100">
                                        <svg class="h-5 w-5 text-neutral-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm text-neutral-600">Type</div>
                                        <div class="text-lg font-semibold text-neutral-900">{{ house.houseType.name }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Sticky Info Card -->
                    <div class="lg:col-span-1">
                        <div class="sticky top-24 rounded-2xl bg-white p-8 shadow-lg ring-1 ring-neutral-200">
                            <!-- Type Badge -->
                            <div v-if="house.houseType" class="mb-4">
                                <span class="inline-flex rounded-full bg-neutral-100 px-3 py-1 text-sm font-medium text-neutral-900">
                                    {{ house.houseType.name }}
                                </span>
                            </div>

                            <!-- Title -->
                            <h1 class="mb-2 text-3xl font-bold text-neutral-900">
                                {{ house.title }}
                            </h1>

                            <!-- Address -->
                            <p class="mb-6 flex items-center text-neutral-600">
                                <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ house.address }}
                            </p>

                            <!-- Price -->
                            <div class="mb-8 border-t border-neutral-200 pt-6">
                                <div class="text-sm text-neutral-600">Prix</div>
                                <div class="text-4xl font-bold text-neutral-900">
                                    {{ formatPrice(house.price) }}
                                </div>
                            </div>

                            <!-- Contact Button -->
                            <a
                                href="mailto:contact@prestige-immo.be"
                                class="block w-full rounded-full bg-neutral-900 px-6 py-4 text-center text-sm font-semibold text-white transition-all hover:bg-neutral-800 hover:shadow-lg"
                            >
                                Nous contacter
                            </a>

                            <div class="mt-4 text-center text-xs text-neutral-500">
                                Réponse sous 24h
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Similar Properties -->
                <div v-if="similarHouses.length > 0" class="mt-20">
                    <h2 class="mb-8 text-3xl font-bold text-neutral-900">Biens similaires</h2>
                    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        <a
                            v-for="similarHouse in similarHouses"
                            :key="similarHouse.id"
                            :href="`/biens/${similarHouse.id}`"
                            class="group overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-neutral-200 transition-all hover:shadow-xl hover:ring-neutral-300"
                        >
                            <div class="relative aspect-[4/3] overflow-hidden bg-neutral-100">
                                <img
                                    v-if="similarHouse.images && similarHouse.images.length > 0"
                                    :src="similarHouse.images[0].url"
                                    :alt="similarHouse.title"
                                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                                />
                                <div v-else class="flex h-full w-full items-center justify-center">
                                    <svg class="h-16 w-16 text-neutral-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="mb-2 text-2xl font-bold text-neutral-900">
                                    {{ formatPrice(similarHouse.price) }}
                                </div>
                                <h3 class="mb-2 text-lg font-semibold text-neutral-900 line-clamp-1">
                                    {{ similarHouse.title }}
                                </h3>
                                <p class="flex items-center text-sm text-neutral-600">
                                    <svg class="mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ similarHouse.address }}
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </FrontLayout>
</template>
