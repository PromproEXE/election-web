<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import axios from 'axios';
import _ from 'lodash'
</script>
<script>
export default {
    data() {
        return {
            partyList: [],
            selectedParty: {

            },
            addPartyData: {
            },
            rootUrl: route('party')
        }
    },
    methods: {
        selectData(data) {
            this.selectedParty = _.cloneDeep(data)
        },
        async getPartyList() {
            try {
                let res = await axios('/api/party')
                this.partyList = res.data
            }
            catch (err) {
                alert(err)
            }
        },
        async deleteParty(id) {
            try {
                let res = await axios.delete('/api/party/' + id + '/delete')
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
            this.getPartyList()
        },
        async addParty() {
            try {
                //CREATE
                let res = await axios.post('/api/party/create', this.addPartyData)
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
            this.getPartyList()
        },
        async updateParty() {
            try {
                let res = await axios.put('/api/party/' + this.selectedParty.id + '/update', this.selectedParty)
                if (res.statusText == 'OK') {
                    alert('UPDATE')
                    this.closeModal()
                }
            }
            catch (err) {
                alert(err)
            }
            this.getPartyList()
        },
        closeModal() {
            window.location.href = this.rootUrl + '#'
        }
    },
    mounted() {
        this.getPartyList()
    }
}
</script>
<template>
    <AppLayout title="จัดการผู้ใช้งาน">
        <div class="bg-primary rounded-b-lg text-center py-16">
            <h1 class="text-6xl text-secondary font-bold">จัดการพรรค</h1>
        </div>
        <div class="container mx-auto py-7 text-lg">
            <div class="flex justify-end mb-3">
                <a role="button" class="btn btn-success" href="#add-modal">
                    <span class="material-symbols-rounded">
                        add
                    </span>
                    เพิ่มพรรค</a>
            </div>
            <table class="table w-full">
                <thead>
                    <tr>
                        <th class="text-center">หมายเลขพรรค</th>
                        <th>ชื่อพรรค</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover cursor-pointer" v-for="party in partyList">
                        <td class="text-center">{{ party.party_number }}</td>
                        <td>{{ party.party_name || '-' }}</td>
                        <td>
                            <a href="#edit-modal" role="button" class="btn btn-warning mr-2"
                                @click="selectData(party)">แก้ไข</a>
                            <a href="#delete-modal" role="button" class="btn btn-error"
                                @click="selectData(party)">ลบ</a>
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
                <p class="text-xl mb-9">คุณต้องการลบ <span class="font-bold">{{ selectedParty.party_name }}</span>
                    หรือไม่</p>
                <div class="grid grid-cols-2">
                    <a href="#" role="button" class="btn base-100 mr-2 text-lg">ยกเลิก</a>
                    <button class="btn btn-error text-lg" @click="deleteParty(selectedParty.id)">ลบ</button>
                </div>
            </div>
        </div>

        <div class="modal" tabindex="-1" id="edit-modal">
            <div class="modal-box relative">
                <div class="flex justify-between items-center">
                    <p class="font-bold text-2xl">แก้ไขข้อมูลพรรค</p>
                    <a href="#" role="button" class="btn btn-circle btn-ghost top-1">✕</a>
                </div>
                <label for="edit-add-name" class="label">
                    <h6>หมายเลขพรรค</h6>
                </label>
                <input type="number" min="1" id="edit-add-name" class="input input-bordered w-full"
                    v-model="selectedParty.party_number">
                <label for="edit-add-password" class="label">
                    <h6>ชื่อพรรค</h6>
                </label>
                <input type="text" id="edit-add-password" class="input input-bordered w-full"
                    v-model="selectedParty.party_name">
                <div class="modal-action">
                    <a class="btn btn-base-100" href="#">ยกเลิก</a>
                    <a class="btn btn-success" @click="updateParty(selectedParty)">บันทึก</a>
                </div>
            </div>
        </div>

        <div class="modal" tabindex="-1" id="add-modal">
            <div class="modal-box relative">
                <div class="flex justify-between items-center">
                    <p class="font-bold text-2xl">เพิ่มพรรค</p>
                    <a href="#" role="button" class="btn btn-circle btn-ghost top-1">✕</a>
                </div>
                <label for="edit-add-name" class="label">
                    <h6>หมายเลขพรรค</h6>
                </label>
                <input type="number" min="1" id="edit-add-name" class="input input-bordered w-full"
                    v-model="addPartyData.party_number">
                <label for="edit-add-password" class="label">
                    <h6>ชื่อพรรค</h6>
                </label>
                <input type="text" id="edit-add-password" class="input input-bordered w-full"
                    v-model="addPartyData.party_name">
                <div class="modal-action">
                    <a class="btn btn-base-100" href="#">ยกเลิก</a>
                    <a class="btn btn-success" type="button" @click="addParty()">บันทึก</a>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
