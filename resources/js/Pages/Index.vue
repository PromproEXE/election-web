<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="p-10">
            <div class="grid grid-cols-2 gap-5">
                <div class="bg-secondary rounded-xl p-5 drop-shadow-xl">
                    <p class="text-4xl font-bold text-primary">ระบบเลือกตั้ง</p>
                </div>
                <div class="grid grid-cols-1">
                    <div class="bg-secondary rounded-xl p-5 mb-5 drop-shadow-xl">
                        <p class="text-4xl font-bold text-primary">ระบบลงทะเบียนผู้เลือกตั้ง</p>
                    </div>
                    <div class="bg-secondary rounded-xl p-5 mb-5 drop-shadow-xl">
                        <p class="text-4xl font-bold text-primary">ระบบจัดการเครื่องเลือกตั้ง</p>
                    </div>
                    <div class="bg-secondary rounded-xl p-5 drop-shadow-xl">
                        <p class="text-4xl font-bold text-primary">ระบบจัดการพรรค</p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
