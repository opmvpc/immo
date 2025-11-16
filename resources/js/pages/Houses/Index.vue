<script setup>
import {
    create,
    destroy,
    edit,
    index,
    show,
} from '@/actions/App/Http/Controllers/HouseController';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
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
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    houses: Object,
    filters: Object,
    houseTypes: Array,
});

// État local pour les filtres
const search = ref(props.filters.search || '');
const houseTypeId = ref(props.filters.house_type_id || '');
const minPrice = ref(props.filters.min_price || '');
const maxPrice = ref(props.filters.max_price || '');
const bedrooms = ref(props.filters.bedrooms || '');
const minSize = ref(props.filters.min_size || '');

// Dialog de confirmation de suppression
const deleteDialog = ref(false);
const houseToDelete = ref(null);

// Appliquer les filtres avec debounce
let timeout = null;
const applyFilters = () => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        router.get(
            index.url(),
            {
                search: search.value || undefined,
                house_type_id: houseTypeId.value || undefined,
                min_price: minPrice.value || undefined,
                max_price: maxPrice.value || undefined,
                bedrooms: bedrooms.value || undefined,
                min_size: minSize.value || undefined,
            },
            {
                preserveState: true,
                preserveScroll: true,
            },
        );
    }, 300);
};

watch(
    [search, houseTypeId, minPrice, maxPrice, bedrooms, minSize],
    applyFilters,
);

const confirmDelete = (house) => {
    houseToDelete.value = house;
    deleteDialog.value = true;
};

const deleteHouse = () => {
    if (houseToDelete.value) {
        router.delete(destroy(houseToDelete.value.id), {
            onSuccess: () => {
                deleteDialog.value = false;
                houseToDelete.value = null;
            },
        });
    }
};

const formatPrice = (price) => {
    return new Intl.NumberFormat('fr-FR', {
        style: 'currency',
        currency: 'EUR',
    }).format(price);
};
</script>

<template>
    <AppLayout>
        <div class="container mx-auto px-3 py-8">
            <!-- Header -->
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">Mes Biens Immobiliers</h1>
                    <p class="text-muted-foreground">
                        Gérez vos biens immobiliers en toute simplicité
                    </p>
                </div>
                <Button @click="router.visit(create())">
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

            <!-- Filtres -->
            <Card class="mb-8">
                <CardHeader>
                    <CardTitle>Recherche et Filtres</CardTitle>
                    <CardDescription>
                        Trouvez rapidement le bien que vous recherchez
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-6">
                        <div>
                            <Input
                                v-model="search"
                                placeholder="Rechercher..."
                                type="text"
                            />
                        </div>
                        <div>
                            <select
                                v-model="houseTypeId"
                                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-xs transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                <option value="">Tous les types</option>
                                <option
                                    v-for="type in houseTypes"
                                    :key="type.id"
                                    :value="type.id"
                                >
                                    {{ type.name }}
                                </option>
                            </select>
                        </div>
                        <div>
                            <Input
                                v-model="minPrice"
                                placeholder="Prix min"
                                type="number"
                                step="1000"
                            />
                        </div>
                        <div>
                            <Input
                                v-model="maxPrice"
                                placeholder="Prix max"
                                type="number"
                                step="1000"
                            />
                        </div>
                        <div>
                            <Input
                                v-model="bedrooms"
                                placeholder="Chambres"
                                type="number"
                                min="0"
                            />
                        </div>
                        <div>
                            <Input
                                v-model="minSize"
                                placeholder="Taille min (m²)"
                                type="number"
                                step="10"
                            />
                        </div>
                    </div>
                </CardContent>
            </Card>

            <!-- Liste des maisons -->
            <div v-if="houses.data.length > 0" class="space-y-6">
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <Card
                        v-for="house in houses.data"
                        :key="house.id"
                        class="overflow-hidden transition-shadow hover:shadow-lg"
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
                                    class="h-16 w-16 text-muted-foreground"
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

                        <CardHeader>
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <CardTitle class="line-clamp-1">{{
                                        house.title
                                    }}</CardTitle>
                                    <CardDescription class="line-clamp-1">
                                        {{ house.address }}
                                    </CardDescription>
                                </div>
                            </div>
                        </CardHeader>

                        <CardContent>
                            <div class="mb-4 space-y-2">
                                <div class="text-2xl font-bold text-primary">
                                    {{ formatPrice(house.price) }}
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    <Badge v-if="house.houseType">
                                        {{ house.houseType.name }}
                                    </Badge>
                                    <Badge variant="secondary">
                                        {{ house.bedrooms }} ch.
                                    </Badge>
                                    <Badge variant="secondary">
                                        {{ house.size }} m²
                                    </Badge>
                                    <Badge
                                        v-if="house.images.length > 0"
                                        variant="outline"
                                    >
                                        {{ house.images.length }} photo{{
                                            house.images.length > 1 ? 's' : ''
                                        }}
                                    </Badge>
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <Button
                                    variant="outline"
                                    size="sm"
                                    class="flex-1"
                                    @click="router.visit(show(house.id))"
                                >
                                    Voir
                                </Button>
                                <Button
                                    variant="outline"
                                    size="sm"
                                    class="flex-1"
                                    @click="router.visit(edit(house.id))"
                                >
                                    Éditer
                                </Button>
                                <Button
                                    variant="destructive"
                                    size="sm"
                                    @click="confirmDelete(house)"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4"
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
                                </Button>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <!-- Pagination -->
                <div
                    v-if="houses.links.length > 3"
                    class="flex justify-center gap-2"
                >
                    <button
                        v-for="link in houses.links"
                        :key="link.label"
                        type="button"
                        :class="[
                            'inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium whitespace-nowrap ring-offset-background transition-colors focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0',
                            'h-9 px-3',
                            link.active
                                ? 'bg-primary text-primary-foreground hover:bg-primary/90'
                                : 'border border-input bg-background hover:bg-accent hover:text-accent-foreground',
                        ]"
                        :disabled="!link.url"
                        @click="link.url && router.visit(link.url)"
                        v-html="link.label"
                    />
                </div>
            </div>

            <!-- Empty state -->
            <Card v-else>
                <CardContent
                    class="flex flex-col items-center justify-center py-16"
                >
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
                    <Button @click="router.visit(create())">
                        Ajouter une maison
                    </Button>
                </CardContent>
            </Card>
        </div>

        <!-- Dialog de confirmation de suppression -->
        <Dialog v-model:open="deleteDialog">
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Confirmer la suppression</DialogTitle>
                    <DialogDescription>
                        Êtes-vous sûr de vouloir supprimer "{{
                            houseToDelete?.title
                        }}" ? Cette action est irréversible.
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
