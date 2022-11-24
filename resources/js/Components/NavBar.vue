<script setup>
import { Inertia } from '@inertiajs/inertia';
const logout = () => {
    Inertia.post(route('logout'));
};
</script>

<template>
    <nav class="navbar bg-base-100">
        <div class="navbar-start">
            <div class="dropdown">
                <label tabindex="0" class="btn btn-ghost lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </label>
                <ul tabindex="0"
                    class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
                    <li v-if="$page.props.user.role.elector"><a :href="route('election')"
                            class="rounded-xl">ระบบลงคะแนน</a></li>
                    <li v-if="$page.props.user.role.monitor"><a :href="route('monitor')"
                            class="rounded-xl">ระบบมอนิเตอร์คะแนน</a></li>
                    <li v-if="$page.props.user.role.register"><a :href="route('register-elector')"
                            class="rounded-xl">ระบบลงทะเบียนผู้เลือกตั้ง</a></li>
                    <li v-if="$page.props.user.role.admin"><a :href="route('users')" class="rounded-xl">ผู้ใช้งาน</a>
                    </li>
                    <li tabindex="0" v-if="$page.props.user.role.admin" style="z-index: 1080;">
                        <a class="rounded-xl">
                            ตั้งค่า
                            <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24">
                                <path d="M7.41,8.58L12,13.17L16.59,8.58L18,10L12,16L6,10L7.41,8.58Z" />
                            </svg>
                        </a>
                        <ul class="p-2 bg-base-100 drop-shadow-xl rounded-xl">
                            <li>
                                <a :href="route('party')">
                                    <span class="material-symbols-rounded">
                                        format_list_bulleted
                                    </span>จัดการพรรค
                                </a>
                            </li>
                            <li>
                                <a :href="route('system')">
                                    <span class="material-symbols-rounded">
                                        format_list_bulleted
                                    </span>ตั้งค่าระบบ
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li tabindex="0" v-if="$page.props.user.role.admin" style="z-index: 1080;">
                        <a class="rounded-xl">
                            {{ $page.props.user.name }}
                            <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24">
                                <path d="M7.41,8.58L12,13.17L16.59,8.58L18,10L12,16L6,10L7.41,8.58Z" />
                            </svg>
                        </a>
                        <ul class="p-2 bg-base-100 drop-shadow-xl rounded-xl">
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
            <a class="btn btn-ghost pb-3" :href="route('index')">
                <img src="/img/kjn-election-web-icon.png" alt="logo" style="width: 250px;">
            </a>
        </div>
        <div class="navbar-end hidden lg:flex">
            <ul class="menu menu-horizontal p-0">
                <li v-if="$page.props.user.role.elector"><a :href="route('election')" class="rounded-xl">ระบบลงคะแนน</a>
                </li>
                <li v-if="$page.props.user.role.monitor"><a :href="route('monitor')"
                        class="rounded-xl">ระบบมอนิเตอร์คะแนน</a></li>
                <li v-if="$page.props.user.role.register"><a :href="route('register-elector')"
                        class="rounded-xl">ระบบลงทะเบียนผู้เลือกตั้ง</a></li>
                <li v-if="$page.props.user.role.admin"><a :href="route('users')" class="rounded-xl">ผู้ใช้งาน</a></li>
                <li tabindex="0" v-if="$page.props.user.role.admin" style="z-index: 1080;">
                    <a class="rounded-xl">
                        ตั้งค่า
                        <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            viewBox="0 0 24 24">
                            <path d="M7.41,8.58L12,13.17L16.59,8.58L18,10L12,16L6,10L7.41,8.58Z" />
                        </svg>
                    </a>
                    <ul class="p-2 bg-base-100 drop-shadow-xl rounded-xl">
                        <li>
                            <a :href="route('party')">
                                <span class="material-symbols-rounded">
                                    format_list_bulleted
                                </span>จัดการพรรค
                            </a>
                        </li>
                        <li>
                            <a :href="route('system')">
                                <span class="material-symbols-rounded">
                                    format_list_bulleted
                                </span>ตั้งค่าระบบ
                            </a>
                        </li>
                    </ul>
                </li>
                <li tabindex="0" v-if="$page.props.user.role.admin" style="z-index: 1080;">
                    <a class="rounded-xl">
                        {{ $page.props.user.name }}
                        <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            viewBox="0 0 24 24">
                            <path d="M7.41,8.58L12,13.17L16.59,8.58L18,10L12,16L6,10L7.41,8.58Z" />
                        </svg>
                    </a>
                    <ul class="p-2 bg-base-100 drop-shadow-xl rounded-xl">
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


    <!-- <nav class="navbar bg-base-100">
        <div class="flex-1">
            <a class="btn btn-ghost pb-3" :href="route('index')">
                <img src="/img/kjn-election-web-icon.png" alt="logo" style="width: 250px;">
            </a>
        </div>
        <div class="flex-none">
            <ul class="menu menu-horizontal p-0">
                <li v-if="$page.props.user.role.elector"><a :href="route('election')">ระบบลงคะแนน</a></li>
                <li v-if="$page.props.user.role.monitor"><a :href="route('monitor')">ระบบมอนิเตอร์คะแนน</a></li>
                <li v-if="$page.props.user.role.register"><a
                        :href="route('register-elector')">ระบบลงทะเบียนผู้เลือกตั้ง</a></li>
                <li v-if="$page.props.user.role.admin"><a :href="route('users')">ผู้ใช้งาน</a></li>
                <div v-if="$page.props.user.role.admin" class="dropdown">
                    <label tabindex="0" class="btn btn-ghost font-normal">
                        <p>ตั้งค่า</p>
                        <span class="material-symbols-rounded">expand_more</span>
                    </label>
                    <ul class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52" tabindex="0">
                        <li>
                            <a :href="route('party')">
                                <span class="material-symbols-rounded">
                                    format_list_bulleted
                                </span>จัดการพรรค
                            </a>
                        </li>
                        <li>
                            <a :href="route('system')">
                                <span class="material-symbols-rounded">
                                    format_list_bulleted
                                </span>ตั้งค่าระบบ
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="dropdown">
                    <label tabindex="0" class="btn btn-ghost font-normal">
                        <p>{{ $page.props.user.name }}</p>
                        <span class="material-symbols-rounded">expand_more</span>
                    </label>
                    <ul class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52" tabindex="0">
                        <li><a :href="route('profile.show')"><span
                                    class="material-symbols-rounded">settings</span>การตั้งค่า</a></li>
                        <li>
                            <form method="post" @submit.prevent="logout">
                                <button type="submit"><span
                                        class="material-symbols-rounded mr-2">logout</span>ออกจากระบบ</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </ul>
        </div>
    </nav> -->
</template>
