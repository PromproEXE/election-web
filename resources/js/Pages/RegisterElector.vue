<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

</script>

<template>
    <AppLayout title="ระบบลงทะเบียนผู้เลือกตั้ง">

        <div class="p-5 h-full">
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-white drop-shadow-xl p-7 rounded-2xl">
                    <h1 class="text-5xl font-bold text-primary mb-3">ระบบลงทะเบียนผู้เลือกตั้ง</h1>
                    <p class="text-gray-500 text-lg">ระบบนี้เป็นระบบสำหรับการลงทะเบียนผู้เลือกตั้งและเพิ่มผู้เลือกตั้ง
                        ท่านสามารถกดได้ที่ปุ่มทางด้านขวามือ</p>
                    <div class="flex justify-center">
                        <img src="/img/vote.png" alt="img">
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-y-3">
                    <a role="button" :href="route('register-elector-reg')"
                        class="btn p-4 btn-secondary w-full h-full flex flex-col text-2xl">
                        <p class="material-symbols-rounded mb-3 text-6xl">
                            how_to_reg
                        </p>
                        ลงทะเบียนผู้เลือกตั้ง
                    </a>
                    <div class="grid grid-cols-2 gap-x-3">
                        <a role="button" :href="route('register-elector-add')"
                            class="btn p-4 btn-warning w-full h-full flex flex-col text-2xl">
                            <p class="material-symbols-rounded mb-3 text-6xl">
                                add
                            </p>
                            เพิ่มผู้มีสิทธิ์เลือกตั้ง
                        </a>
                        <a role="button" :href="route('register-elector-edit')"
                            class="btn p-4 btn-gray-200 w-full h-full flex flex-col text-2xl">
                            <p class="material-symbols-rounded mb-3 text-6xl">
                                edit
                            </p>
                            แก้ไขผู้มีสิทธิ์เลือกตั้ง
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
