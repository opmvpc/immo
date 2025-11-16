<script setup>
import { Form } from '@inertiajs/vue3';
import { store, index } from '@/actions/App/Http/Controllers/HouseController';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import { Label } from '@/components/ui/label';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';

const props = defineProps({
    houseTypes: Array,
});
</script>

<template>
    <AppLayout>
        <div class="container mx-auto max-w-3xl px-3 py-8">
            <Card>
                <CardHeader>
                    <CardTitle>Ajouter une maison</CardTitle>
                    <CardDescription>
                        Remplissez les informations ci-dessous pour ajouter un
                        nouveau bien immobilier
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <Form
                        :action="store()"
                        #default="{ errors, processing }"
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
                                placeholder="Ex: Belle maison à Paris"
                            />
                            <p
                                v-if="errors.title"
                                class="text-sm text-destructive"
                            >
                                {{ errors.title }}
                            </p>
                        </div>

                        <!-- Type de bien -->
                        <div class="space-y-2">
                            <Label for="house_type_id">
                                Type de bien
                                <span class="text-destructive">*</span>
                            </Label>
                            <select
                                id="house_type_id"
                                name="house_type_id"
                                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-xs transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                <option value="">Sélectionnez un type</option>
                                <option
                                    v-for="type in houseTypes"
                                    :key="type.id"
                                    :value="type.id"
                                >
                                    {{ type.name }}
                                </option>
                            </select>
                            <p
                                v-if="errors.house_type_id"
                                class="text-sm text-destructive"
                            >
                                {{ errors.house_type_id }}
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
                                placeholder="Décrivez le bien..."
                            />
                            <p
                                v-if="errors.description"
                                class="text-sm text-destructive"
                            >
                                {{ errors.description }}
                            </p>
                        </div>

                        <!-- Info images -->
                        <div
                            class="rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800"
                        >
                            <p class="font-medium">📸 Ajout d'images</p>
                            <p class="mt-1 text-blue-700">
                                Vous pourrez ajouter des images après la création
                                de la maison, dans la page d'édition.
                            </p>
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
                                        : 'Créer la maison'
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
    </AppLayout>
</template>
