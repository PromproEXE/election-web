<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

</script>

<template>
    <AppLayout title="ระบบลงทะเบียนผู้เลือกตั้ง">

        <div class="p-5 h-full">
            <div class="grid grid-cols-3 gap-3">
                <div>
                    <div class="form-control w-full mb-3">
                        <label class="input-group input-group-sm">
                            <span class="material-symbols-rounded">search</span>
                            <input type="text" placeholder="ค้นหาด้วยเลขประจำตัว" class="input input-sm input-bordered w-full" />
                        </label>
                    </div>
                    <div class="bg-base-100 p-3 rounded-xl h-full">
                        <button class="btn btn-ghost w-full flex-col text-xl mb-1">
                            <p class="font-bold">09362</p>
                            <p>นายชาญวิช มาศมัณฑนะ</p>
                        </button>
                        <button class="btn btn-ghost w-full flex-col text-xl mb-1">
                            <p class="font-bold">09362</p>
                            <p>นายชาญวิช มาศมัณฑนะ</p>
                        </button>
                    </div>
                </div>
                <div class="col-span-2">

                </div>
            </div>
        </div>

    </AppLayout>
</template>
