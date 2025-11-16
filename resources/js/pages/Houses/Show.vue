<script setup lang="js">
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { index, edit, destroy } from '@/actions/App/Http/Controllers/HouseController';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';

const props = defineProps({
    house: Object,
});

// Dialog de confirmation de suppression
const deleteDialog = ref(false);

// Galerie d'images
const selectedImageIndex = ref(0);

const deleteHouse = () => {
    router.delete(destroy(props.house.id), {
        onSuccess: () => {
            router.visit(index());
        },
    });
};

const formatPrice = (price) => {
    return new Intl.NumberFormat('fr-FR', {
        style: 'currency',
        currency: 'EUR',
    }).format(price);
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('fr-FR', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};
</script>

<template>
    <AppLayout>
        <div class="container mx-auto max-w-5xl px-3 py-8">
            <!-- Header avec actions -->
            <div class="mb-6 flex items-center justify-between">
                <Button variant="outline" @click="router.visit(index())">
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
                            d="M15 19l-7-7 7-7"
                        />
                    </svg>
                    Retour
                </Button>
                <div class="flex gap-2">
                    <Button @click="router.visit(edit(house.id))">
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
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                            />
                        </svg>
                        Modifier
                    </Button>
                    <Button variant="destructive" @click="deleteDialog = true">
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
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                            />
                        </svg>
                        Supprimer
                    </Button>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <!-- Galerie d'images -->
                <div class="lg:col-span-2">
                    <Card>
                        <CardContent class="p-6">
                            <div
                                v-if="house.images && house.images.length > 0"
                                class="space-y-4"
                            >
                                <!-- Image principale -->
                                <div
                                    class="aspect-video overflow-hidden rounded-lg bg-muted"
                                >
                                    <img
                                        :src="
                                            house.images[selectedImageIndex].url
                                        "
                                        :alt="house.title"
                                        class="h-full w-full object-cover"
                                    />
                                </div>

                                <!-- Miniatures -->
                                <div
                                    v-if="house.images.length > 1"
                                    class="grid grid-cols-4 gap-2"
                                >
                                    <button
                                        v-for="(image, index) in house.images"
                                        :key="image.id"
                                        class="aspect-video overflow-hidden rounded-lg border-2 transition-all"
                                        :class="
                                            selectedImageIndex === index
                                                ? 'border-primary'
                                                : 'border-transparent hover:border-muted-foreground'
                                        "
                                        @click="selectedImageIndex = index"
                                    >
                                        <img
                                            :src="image.url"
                                            :alt="house.title"
                                            class="h-full w-full object-cover"
                                        />
                                    </button>
                                </div>
                            </div>

                            <!-- Pas d'images -->
                            <div
                                v-else
                                class="flex aspect-video items-center justify-center rounded-lg bg-muted"
                            >
                                <div class="text-center">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="mx-auto h-16 w-16 text-muted-foreground"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>
                                    <p class="mt-2 text-muted-foreground">
                                        Aucune image
                                    </p>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <!-- Informations -->
                <div class="space-y-6">
                    <!-- Prix et infos principales -->
                    <Card>
                        <CardHeader>
                            <CardTitle class="text-3xl text-primary">
                                {{ formatPrice(house.price) }}
                            </CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <div class="flex flex-wrap gap-2">
                                <Badge variant="secondary">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="mr-1 h-4 w-4"
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
                                    {{ house.bedrooms }} chambre{{
                                        house.bedrooms > 1 ? 's' : ''
                                    }}
                                </Badge>
                                <Badge variant="secondary">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="mr-1 h-4 w-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"
                                        />
                                    </svg>
                                    {{ house.size }} m²
                                </Badge>
                            </div>

                            <div class="space-y-2 border-t pt-4">
                                <div class="flex items-start gap-2">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="mt-0.5 h-5 w-5 text-muted-foreground"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                        />
                                    </svg>
                                    <span class="text-sm">{{
                                        house.address
                                    }}</span>
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Métadonnées -->
                    <Card>
                        <CardHeader>
                            <CardTitle class="text-base">Informations</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-muted-foreground"
                                    >Créé le</span
                                >
                                <span>{{ formatDate(house.created_at) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-muted-foreground"
                                    >Modifié le</span
                                >
                                <span>{{ formatDate(house.updated_at) }}</span>
                            </div>
                            <div
                                v-if="house.images.length > 0"
                                class="flex justify-between"
                            >
                                <span class="text-muted-foreground"
                                    >Images</span
                                >
                                <span
                                    >{{ house.images.length }} photo{{
                                        house.images.length > 1 ? 's' : ''
                                    }}</span
                                >
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <!-- Description -->
                <div class="lg:col-span-3">
                    <Card>
                        <CardHeader>
                            <CardTitle>{{ house.title }}</CardTitle>
                            <CardDescription>{{ house.address }}</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div
                                v-if="house.description"
                                class="prose prose-sm max-w-none"
                            >
                                <p class="whitespace-pre-line">
                                    {{ house.description }}
                                </p>
                            </div>
                            <p v-else class="text-muted-foreground">
                                Aucune description disponible.
                            </p>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>

        <!-- Dialog de confirmation de suppression -->
        <Dialog v-model:open="deleteDialog">
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Confirmer la suppression</DialogTitle>
                    <DialogDescription>
                        Êtes-vous sûr de vouloir supprimer "{{ house.title }}"
                        ? Cette action est irréversible.
                    </DialogDescription>
                </DialogHeader>
                <DialogFooter>
                    <Button variant="outline" @click="deleteDialog = false">
                        Annuler
                    </Button>
                    <Button variant="destructive" @click="deleteHouse">
                        Supprimer
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </AppLayout>
</template>
