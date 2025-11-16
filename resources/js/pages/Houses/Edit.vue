<script setup lang="js">
import { ref } from 'vue';
import { Form, router } from '@inertiajs/vue3';
import { update, index, deleteImage } from '@/actions/App/Http/Controllers/HouseController';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import { Label } from '@/components/ui/label';
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

// Dialog de confirmation de suppression d'image
const deleteImageDialog = ref(false);
const imageToDelete = ref(null);

const confirmDeleteImage = (image) => {
    imageToDelete.value = image;
    deleteImageDialog.value = true;
};

const removeImage = () => {
    if (imageToDelete.value) {
        router.delete(deleteImage.url(props.house.id, imageToDelete.value.id), {
            preserveScroll: true,
            onSuccess: () => {
                deleteImageDialog.value = false;
                imageToDelete.value = null;
            },
        });
    }
};
</script>

<template>
    <AppLayout>
        <div class="container mx-auto max-w-3xl py-8">
            <Card>
                <CardHeader>
                    <CardTitle>Modifier la maison</CardTitle>
                    <CardDescription>
                        Modifiez les informations de votre bien immobilier
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <Form
                        :action="update(house.id)"
                        #default="{ errors, processing, progress }"
                        class="space-y-6"
                    >
                        <!-- Titre -->
                        <div class="space-y-2">
                            <Label for="title">
                                Titre
                                <span class="text-destructive">*</span>
                            </Label>
                            <Input
                                id="title"
                                type="text"
                                name="title"
                                :defaultValue="house.title"
                                placeholder="Ex: Belle maison à Paris"
                            />
                            <p
                                v-if="errors.title"
                                class="text-sm text-destructive"
                            >
                                {{ errors.title }}
                            </p>
                        </div>

                        <!-- Prix -->
                        <div class="space-y-2">
                            <Label for="price">
                                Prix (€)
                                <span class="text-destructive">*</span>
                            </Label>
                            <Input
                                id="price"
                                type="number"
                                name="price"
                                step="0.01"
                                :defaultValue="house.price"
                                placeholder="250000"
                            />
                            <p
                                v-if="errors.price"
                                class="text-sm text-destructive"
                            >
                                {{ errors.price }}
                            </p>
                        </div>

                        <!-- Adresse -->
                        <div class="space-y-2">
                            <Label for="address">
                                Adresse
                                <span class="text-destructive">*</span>
                            </Label>
                            <Input
                                id="address"
                                type="text"
                                name="address"
                                :defaultValue="house.address"
                                placeholder="123 rue de la Paix, 75001 Paris"
                            />
                            <p
                                v-if="errors.address"
                                class="text-sm text-destructive"
                            >
                                {{ errors.address }}
                            </p>
                        </div>

                        <!-- Chambres et Taille -->
                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="space-y-2">
                                <Label for="bedrooms">
                                    Nombre de chambres
                                    <span class="text-destructive">*</span>
                                </Label>
                                <Input
                                    id="bedrooms"
                                    type="number"
                                    name="bedrooms"
                                    :defaultValue="house.bedrooms"
                                    placeholder="3"
                                    min="0"
                                />
                                <p
                                    v-if="errors.bedrooms"
                                    class="text-sm text-destructive"
                                >
                                    {{ errors.bedrooms }}
                                </p>
                            </div>

                            <div class="space-y-2">
                                <Label for="size">
                                    Taille (m²)
                                    <span class="text-destructive">*</span>
                                </Label>
                                <Input
                                    id="size"
                                    type="number"
                                    name="size"
                                    step="0.01"
                                    :defaultValue="house.size"
                                    placeholder="120.50"
                                    min="0"
                                />
                                <p
                                    v-if="errors.size"
                                    class="text-sm text-destructive"
                                >
                                    {{ errors.size }}
                                </p>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="space-y-2">
                            <Label for="description">Description</Label>
                            <Textarea
                                id="description"
                                name="description"
                                rows="5"
                                :defaultValue="house.description"
                                placeholder="Décrivez le bien..."
                            />
                            <p
                                v-if="errors.description"
                                class="text-sm text-destructive"
                            >
                                {{ errors.description }}
                            </p>
                        </div>

                        <!-- Images existantes -->
                        <div
                            v-if="house.images && house.images.length > 0"
                            class="space-y-2"
                        >
                            <Label>Images actuelles</Label>
                            <div class="grid gap-4 md:grid-cols-3">
                                <div
                                    v-for="image in house.images"
                                    :key="image.id"
                                    class="group relative aspect-video overflow-hidden rounded-lg border"
                                >
                                    <img
                                        :src="image.url"
                                        :alt="house.title"
                                        class="h-full w-full object-cover"
                                    />
                                    <div
                                        class="absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 transition-opacity group-hover:opacity-100"
                                    >
                                        <Button
                                            size="sm"
                                            variant="destructive"
                                            @click="confirmDeleteImage(image)"
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
                                </div>
                            </div>
                        </div>

                        <!-- Ajouter de nouvelles images -->
                        <div class="space-y-2">
                            <Label for="images">Ajouter de nouvelles images</Label>
                            <input
                                id="images"
                                type="file"
                                name="images"
                                multiple
                                accept="image/*"
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                            />
                            <p class="text-sm text-muted-foreground">
                                Vous pouvez sélectionner plusieurs images (max
                                2MB par image)
                            </p>
                            <p
                                v-if="errors['images.0']"
                                class="text-sm text-destructive"
                            >
                                {{ errors['images.0'] }}
                            </p>
                        </div>

                        <!-- Progression upload -->
                        <div v-if="progress" class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span>Upload en cours...</span>
                                <span class="font-medium"
                                    >{{ progress.percentage }}%</span
                                >
                            </div>
                            <div class="h-2 w-full rounded-full bg-secondary">
                                <div
                                    class="h-2 rounded-full bg-primary transition-all"
                                    :style="{
                                        width: `${progress.percentage}%`,
                                    }"
                                />
                            </div>
                        </div>

                        <!-- Boutons -->
                        <div class="flex gap-4">
                            <Button type="submit" :disabled="processing">
                                <svg
                                    v-if="processing"
                                    class="mr-2 h-4 w-4 animate-spin"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        class="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="4"
                                    ></circle>
                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                    ></path>
                                </svg>
                                {{
                                    processing
                                        ? 'Enregistrement...'
                                        : 'Mettre à jour'
                                }}
                            </Button>

                            <Button
                                type="button"
                                variant="outline"
                                @click="$inertia.visit(index())"
                            >
                                Annuler
                            </Button>
                        </div>
                    </Form>
                </CardContent>
            </Card>
        </div>

        <!-- Dialog de confirmation de suppression d'image -->
        <Dialog v-model:open="deleteImageDialog">
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Supprimer l'image</DialogTitle>
                    <DialogDescription>
                        Êtes-vous sûr de vouloir supprimer cette image ? Cette
                        action est irréversible.
                    </DialogDescription>
                </DialogHeader>
                <DialogFooter>
                    <Button
                        variant="outline"
                        @click="deleteImageDialog = false"
                    >
                        Annuler
                    </Button>
                    <Button variant="destructive" @click="removeImage">
                        Supprimer
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </AppLayout>
</template>
