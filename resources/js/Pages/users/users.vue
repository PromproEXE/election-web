<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import axios from 'axios';
import _ from 'lodash'
</script>
<script>
export default {
    data() {
        return {
            userList: [],
            selectedUser: {
                name: '',
                role: {
                    elector: false,
                    register: false,
                    monitor: false,
                    admin: false,
                }
            },
            addUserData: {
                name: '',
                email: '',
                password: ''
            },
            rootUrl: route('users')
        }
    },
    methods: {
        selectData(data) {
            this.selectedUser = _.cloneDeep(data)
        },
        async getUserList() {
            try {
                let res = await axios('/api/users')
                this.userList = res.data
            }
            catch (err) {
                alert(err)
            }
        },
        async deleteUser(id) {
            try {
                let res = await axios.delete('/api/users/' + id + '/delete')
                if (res.statusText == 'OK') {
                    alert('DELETE')
                    this.closeModal()
                }
                else {
                    alert('ERROR')
                }
            }
            catch (err) {
                alert(err)
            }
            this.getUserList()
        },
        async addUser() {
            try {
                //VALIDATE
                if (this.addUserData.name == '' || this.addUserData.password == '') {
                    alert('ใส่ข้อมูลไม่ครบ')
                    return
                }
                if (this.addUserData.password != this.addUserData.confirm_password) {
                    alert('รหัสไม่ตรงกัน')
                    return
                }

                //CREATE
                let res = await axios.post('/api/users/create', this.addUserData)
                if (res.statusText == 'Created') {
                    alert('ADD USER')
                    this.closeModal()
                }
                else {
                    alert('ERR')
                }
            }
            catch (err) {
                alert(err)
            }
            this.getUserList()
        },
        async updateData() {
            try {
                let res = await axios.put('/api/users/' + this.selectedUser.id + '/update', this.selectedUser)
                if (res.statusText == 'OK') {
                    alert('UPDATE')
                    this.closeModal()
                }
            }
            catch (err) {
                alert(err)
            }
            this.getUserList()
        },
        closeModal() {
            window.location.href = this.rootUrl + '#'
        }
    },
    mounted() {
        this.getUserList()
    }
}
</script>
<template>
    <AppLayout title="จัดการผู้ใช้งาน">
        <div class="bg-primary rounded-b-lg text-center py-16">
            <h1 class="text-6xl text-secondary font-bold">จัดการผู้ใช้งาน</h1>
        </div>
        <div class="container mx-auto py-7 text-lg">
            <div class="flex justify-end mb-3">
                <a role="button" class="btn btn-success" href="#add-modal">
                    <span class="material-symbols-rounded">
                        add
                    </span>
                    เพิ่มผู้ใช้งาน</a>
            </div>
            <table class="table w-full">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>ชื่อ</th>
                        <th class="text-center">เลือกตั้ง</th>
                        <th class="text-center">ลงทะเบียนผู้เลือกตั้ง</th>
                        <th class="text-center">Monitor</th>
                        <th class="text-center">Admin</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover cursor-pointer" v-for="(user, i) in userList">
                        <td class="text-center">{{ i + 1 }}</td>
                        <td>{{ user.name }}</td>
                        <td class="text-center">
                            <span class="material-symbols-rounded">
                                {{ user.role.elector ? 'done' : 'close' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="material-symbols-rounded">
                                {{ user.role.register ? 'done' : 'close' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="material-symbols-rounded">
                                {{ user.role.monitor ? 'done' : 'close' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="material-symbols-rounded">
                                {{ user.role.admin ? 'done' : 'close' }}
                            </span>
                        </td>
                        <td>
                            <a href="#edit-modal" role="button" class="btn btn-warning mr-2"
                                @click="selectData(user)"><span class="material-symbols-rounded mr-1">
                                    edit
                                </span>แก้ไข</a>
                            <a href="#delete-modal" role="button" class="btn btn-error" @click="selectData(user)"><span
                                    class="material-symbols-rounded mr-1">
                                    delete
                                </span>ลบ</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="modal" id="delete-modal">
            <div class="modal-box text-center relative">
                <div class="flex justify-end">
                    <a role="button" href="#" class="btn btn-circle btn-ghost">X</a>
                </div>
                <p class="text-xl mb-9">คุณต้องการลบ <span class="font-bold">{{ selectedUser.name }}</span> หรือไม่</p>
                <div class="grid grid-cols-2">
                    <a href="#" role="button" class="btn base-100 mr-2 text-lg">ยกเลิก</a>
                    <button class="btn btn-error text-lg" @click="deleteUser(selectedUser.id)">ลบ</button>
                </div>
            </div>
        </div>

        <div class="modal" tabindex="-1" id="edit-modal">
            <div class="modal-box relative">
                <div class="flex justify-between items-center">
                    <p class="font-bold text-2xl">แก้ไขข้อมูลผู้ใช้งาน</p>
                    <a href="#" role="button" class="btn btn-circle btn-ghost top-1">✕</a>
                </div>
                <label for="edit-name" class="label">
                    <h6>สิทธิ์การใช้งาน</h6>
                </label>
                <div class="inline mr-2">
                    <input type="checkbox" id="edit-elector" class="checkbox mr-2"
                        v-model="selectedUser.role.elector" />
                    <label class="label-text" for="edit-elector">เลือกตั้ง</label>
                </div>
                <div class="inline mr-2">
                    <input type="checkbox" id="edit-register" class="checkbox mr-2"
                        v-model="selectedUser.role.register" />
                    <label class="label-text" for="edit-register">ลงทะเบียนผู้เลือกตั้ง</label>
                </div>
                <div class="inline mr-2">
                    <input type="checkbox" id="edit-monitor" class="checkbox mr-2"
                        v-model="selectedUser.role.monitor" />
                    <label class="label-text" for="edit-monitor">Monitor</label>
                </div>
                <div class="inline">
                    <input type="checkbox" id="edit-admin" class="checkbox mr-2" v-model="selectedUser.role.admin" />
                    <label class="label-text" for="edit-admin">Admin</label>
                </div>
                <div class="modal-action">
                    <a class="btn btn-base-100" href="#">ยกเลิก</a>
                    <a class="btn btn-success" @click="updateData(selectedUser)">บันทึก</a>
                </div>
            </div>
        </div>

        <div class="modal" tabindex="-1" id="add-modal">
            <div class="modal-box relative">
                <div class="flex justify-between items-center">
                    <p class="font-bold text-2xl">เพิ่มผู้ใช้งาน</p>
                    <a href="#" role="button" class="btn btn-circle btn-ghost top-1">✕</a>
                </div>
                <label for="edit-add-name" class="label">
                    <h6>Username</h6>
                </label>
                <input type="text" id="edit-add-name" class="input input-bordered w-full" v-model="addUserData.name">
                <label for="edit-add-password" class="label">
                    <h6>รหัสผ่าน</h6>
                </label>
                <input type="password" id="edit-add-password" class="input input-bordered w-full"
                    v-model="addUserData.password">
                <label for="edit-add-confirm-password" class="label">
                    <h6>ยืนยันรหัสผ่าน</h6>
                </label>
                <input type="password" id="edit-add-confirm-password" class="input input-bordered w-full"
                    v-model="addUserData.confirm_password">
                <div class="modal-action">
                    <a class="btn btn-base-100" href="#">ยกเลิก</a>
                    <a class="btn btn-success" type="button" @click="addUser()">บันทึก</a>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
