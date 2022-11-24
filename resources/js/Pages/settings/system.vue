<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import axios from 'axios';
import _ from 'lodash'
</script>
<script>
export default {
    data() {
        return {
            settingsList: [],
            selectedSetting: {

            },
            addSettingData: {
            },
            rootUrl: route('system')
        }
    },
    methods: {
        selectData(data) {
            this.selectedSetting = _.cloneDeep(data)
        },
        async getSettingList() {
            try {
                let res = await axios('/api/settings')
                this.settingsList = res.data
            }
            catch (err) {
                alert(err)
            }
        },
        async deleteSetting(id) {
            try {
                let res = await axios.delete('/api/settings/' + id + '/delete')
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
            this.getSettingList()
        },
        async addSetting() {
            try {
                //CREATE
                let res = await axios.post('/api/settings/create', this.addSetting)
                if (res.statusText == 'Created') {
                    alert('ADD PARTY')
                    this.closeModal()
                }
                else {
                    alert('ERR')
                }
            }
            catch (err) {
                alert(err)
            }
            this.getSettingList()
        },
        async updateSetting() {
            try {
                let res = await axios.put('/api/settings/' + this.selectedSetting.id + '/update', this.selectedSetting)
                if (res.statusText == 'OK') {
                    alert('UPDATE')
                    this.closeModal()
                }
            }
            catch (err) {
                alert(err)
            }
            this.getSettingList()
        },
        closeModal() {
            window.location.href = this.rootUrl + '#'
        }
    },
    mounted() {
        this.getSettingList()
    }
}
</script>
<template>
    <AppLayout title="จัดการผู้ใช้งาน">
        <div class="bg-primary rounded-b-lg text-center py-16">
            <h1 class="text-6xl text-secondary font-bold">ตั้งค่าระบบ</h1>
        </div>
        <div class="container mx-auto py-7 text-lg">
            <div class="flex justify-end mb-3">
                <a role="button" class="btn btn-success" href="#add-modal">
                    <span class="material-symbols-rounded">
                        add
                    </span>
                    เพิ่มการตั้งค่า</a>
            </div>
            <table class="table w-full">
                <thead>
                    <tr>
                        <th class="text-center">ชื่อการตั้งค่า</th>
                        <th>ค่า</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover cursor-pointer" v-for="setting in settingsList">
                        <td class="text-center">{{ setting.settings_name }}</td>
                        <td>{{ setting.value || '-' }}</td>
                        <td>
                            <a href="#edit-modal" role="button" class="btn btn-warning mr-2"
                                @click="selectData(setting)"><span class="material-symbols-rounded mr-1">
                                    edit
                                </span>แก้ไข</a>
                            <a href="#delete-modal" role="button" class="btn btn-error"
                                @click="selectData(setting)"><span class="material-symbols-rounded mr-1">
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
                <p class="text-xl mb-9">คุณต้องการลบ <span class="font-bold">{{ selectedSetting.settings_name }}</span>
                    หรือไม่</p>
                <div class="grid grid-cols-2">
                    <a href="#" role="button" class="btn base-100 mr-2 text-lg">ยกเลิก</a>
                    <button class="btn btn-error text-lg" @click="deleteSetting(selectedSetting.id)">ลบ</button>
                </div>
            </div>
        </div>

        <div class="modal" tabindex="-1" id="edit-modal">
            <div class="modal-box relative">
                <div class="flex justify-between items-center">
                    <p class="font-bold text-2xl">ตั้งค่า {{ selectedSetting.settings_name }}</p>
                    <a href="#" role="button" class="btn btn-circle btn-ghost top-1">✕</a>
                </div>
                <label for="edit-value" class="label">
                    <h6>ค่า</h6>
                </label>
                <input type="text" id="edit-value" class="input input-bordered w-full" v-model="selectedSetting.value">
                <div class="modal-action">
                    <a class="btn btn-base-100" href="#">ยกเลิก</a>
                    <a class="btn btn-success" @click="updateSetting(selectedSetting)">บันทึก</a>
                </div>
            </div>
        </div>

        <div class="modal" tabindex="-1" id="add-modal">
            <div class="modal-box relative">
                <div class="flex justify-between items-center">
                    <p class="font-bold text-2xl">เพิ่มการตั้งค่า</p>
                    <a href="#" role="button" class="btn btn-circle btn-ghost top-1">✕</a>
                </div>
                <label for="edit-add-name" class="label">
                    <h6>ชื่อการตั้งค่า</h6>
                </label>
                <input type="number" min="1" id="edit-add-name" class="input input-bordered w-full"
                    v-model="addSettingData.settings_name">
                <label for="edit-add-password" class="label">
                    <h6>ค่า</h6>
                </label>
                <input type="text" id="edit-add-password" class="input input-bordered w-full"
                    v-model="addSettingData.value">
                <div class="modal-action">
                    <a class="btn btn-base-100" href="#">ยกเลิก</a>
                    <a class="btn btn-success" type="button" @click="addSetting()">บันทึก</a>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
