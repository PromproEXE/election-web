<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import InputFile from '@/Components/inputFile.vue';
import axios from 'axios'
import _ from 'lodash'
</script>

<script>
export default {
    data() {
        return {
            nameList: [],
            selectedData: {}
        }
    },
    methods: {
        async updateData(data) {
            try {
                let res = await axios.put('/api/elector/' + data.id + '/update', data)
                if (res.status != 200) {
                    return
                }
                this.getNameList()
                alert('UPDATE')
            }
            catch (err) {
                console.log(err)
            }
        },
        async getNameList() {
            let res = await axios('/api/elector')
            this.nameList = res.data
        },
        async deleteData(id) {
            try {
                let res = await axios.delete('/api/elector/' + id + '/delete')
                alert('DELETE')
            }
            catch (err) {
                console.log(err)
            }
            this.getNameList()
        },
        selectData(data) {
            this.selectedData = _.cloneDeep(data)
        }
    },
    async mounted() {
        this.getNameList()
    }
}
</script>
<template>
    <AppLayout title="แก้ไขผู้มีสิทธิ์เลือกตั้ง">
        <div class="bg-primary rounded-b-lg text-center py-16">
            <h1 class="text-6xl text-secondary font-bold">แก้ไขรายชื่อผู้มีสิทธิ์เลือกตั้ง</h1>
        </div>
        <div class="container mx-auto py-7 text-lg">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>เลขประจำตัว</th>
                        <th>ชั้น</th>
                        <th>ห้อง</th>
                        <th>ชื่อ-นามสกุล</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover cursor-pointer" v-for="(data, i) in nameList">
                        <td class="text-center">{{ i + 1 }}</td>
                        <td>{{ data.id }}</td>
                        <td>{{ data.class }}</td>
                        <td>{{ data.room }}</td>
                        <td>{{ data.name }}</td>
                        <td>
                            <a href="#edit-modal" role="button" class="btn btn-warning mr-2"
                                @click="selectData(data)">แก้ไข</a>
                            <a href="#delete-modal" role="button" class="btn btn-error" @click="selectData(data)">ลบ</a>
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
                <p class="text-xl mb-9">คุณต้องการลบ <span class="font-bold">{{ selectedData.name }}</span> หรือไม่</p>
                <div class="grid grid-cols-2">
                    <a href="#" role="button" class="btn base-100 mr-2 text-lg">ยกเลิก</a>
                    <button class="btn btn-error text-lg" @click="deleteData(selectedData.id)">ลบ</button>
                </div>
            </div>
        </div>

        <div class="modal" tabindex="-1" id="edit-modal">
            <div class="modal-box relative">
                <div class="flex justify-between items-center">
                    <p class="font-bold text-2xl">แก้ไขข้อมูล</p>
                    <a href="#" role="button" class="btn btn-circle btn-ghost top-1">✕</a>
                </div>
                <label for="edit-name" class="label">
                    <h6>ชื่อ-นามสกุล</h6>
                </label>
                <input type="text" id="edit-name" class="input input-bordered w-full" v-model="selectedData.name">
                <label for="edit-class" class="label">
                    <h6>ชั้นมัธยมศึกษาปีที่</h6>
                </label>
                <input type="number" min="1" max="6" id="edit-class" class="input input-bordered w-full"
                    v-model="selectedData.class">
                <label for="edit-room" class="label">
                    <h6>ห้อง</h6>
                </label>
                <input type="number" min="1" id="edit-room" class="input input-bordered w-full"
                    v-model="selectedData.room">
                <div class="modal-action">
                    <a class="btn btn-base-100" href="#">ยกเลิก</a>
                    <a class="btn btn-success" @click="updateData(selectedData)">บันทึก</a>
                </div>
            </div>
        </div>

    </AppLayout>
</template>
