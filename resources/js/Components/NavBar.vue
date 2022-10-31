<script setup>
import { Inertia } from '@inertiajs/inertia';
const logout = () => {
    Inertia.post(route('logout'));
};
</script>

<template>
    <nav class="navbar bg-base-100">
        <div class="flex-1">
            <a class="btn btn-ghost pb-3" :href="route('index')">
                <img src="/img/kjn-election-web-icon.png" alt="logo" style="width: 250px;">
            </a>
        </div>
        <div class="flex-none">
            <ul class="menu menu-horizontal p-0">
                <li><a :href="route('election')">ระบบลงคะแนน</a></li>
                <li><a>ระบบมอนิเตอร์คะแนน</a></li>
                <li><a :href="route('register-elector')">ระบบลงทะเบียนผู้เลือกตั้ง</a></li>
                <li><a :href="route('users')">ผู้ใช้งาน</a></li>
                <div class="dropdown">
                    <label tabindex="0" class="btn btn-ghost font-normal">
                        <p>ตั้งค่า</p>
                        <span class="material-symbols-rounded">expand_more</span>
                    </label>
                    <ul class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52" tabindex="0">
                        <li>
                            <a :href="route('party-list')">
                                <span class="material-symbols-rounded">
                                    format_list_bulleted
                                </span>จัดการพรรค
                            </a>
                        </li>
                    </ul>
                </div>
                <li tabindex="0">
                    <a class="justify-start">
                        <p>{{ $page.props.user.name }}</p>
                        <span class="material-symbols-rounded">expand_more</span>
                    </a>
                    <ul class="p-2 bg-base-100">
                        <li><a :href="route('profile.show')"><span
                                    class="material-symbols-rounded">settings</span>การตั้งค่า</a></li>
                        <li>
                            <form method="post" @submit.prevent="logout">
                                <button type="submit"><span
                                        class="material-symbols-rounded mr-2">logout</span>ออกจากระบบ</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</template>
