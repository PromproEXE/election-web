<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import axios from 'axios'
import _ from 'lodash'
</script>

<script>
export default {
    data() {
        return {
            nameList: [],
            displayNameList: [],
            userList: [],
            selectedData: null,
            selectedUser: {

            },
            voted: 0,
            searchText: '',
            settings: [],
            studentAmount: localStorage.getItem('studentAmount'),
            rootUrl: route('register-elector-reg')
        }
    },
    methods: {
        CreateToast(isValid) { // Toast notification

            let toastDiv = document.createElement("div");

            // Give it a unique id
            toastDiv.id = "toast_" + toastCounter;

            // Make it hidden (necessary to slideDown)
            toastDiv.style.display = "none";

            let toastMessage;
            let foreColor;
            let backgroundColor;
            let borderColor;

            if (!isValid) {
                toastMessage = "Failure";
                foreColor = "";
                backgroundColor = "";
                borderColor = "";
            } else {
                toastMessage = "Success";
                foreColor = "";
                backgroundColor = "";
                borderColor = "";
            }

            toastDiv.innerHTML = toastMessage;
            document.body.appendChild(toastDiv);

            // Increment toastCounter
            toastCounter++;
        },
        async updateElectorData(data) {
            try {
                let res = await axios.post('/api/elector/' + data.id + '/update', data)
                if (res.status != 200) {
                    return
                }
                alert('UPDATE')
            }
            catch (err) {
                console.log(err)
            }
            this.getNameList()
        },
        async updateUserData(data) {
            try {
                let res = await axios.put('/api/users/' + data.id + '/update', data)
                if (res.statusText == 'OK') {
                    alert('UPDATE USER')
                }
                else {
                    alert('ERR')
                }
            }
            catch (err) {
                alert('ERR')
            }
            this.getUserList()
        },
        async getNameList() {
            let res = await axios('/api/elector')
            this.nameList = res.data
            this.performSearch()
        },
        async getUserList() {
            let res = await axios('/api/users')
            this.userList = res.data
        },
        async getVoteCount() {
            let res = await axios('/api/vote_count/count')
            this.voted = res.data.count
        },
        async getSettings() {
            let res = await axios('/api/settings')
            this.settings = res.data
        },
        performSearch() {
            if (this.searchText == '') {
                this.displayNameList = this.nameList
            }
            else {
                this.displayNameList = this.nameList.filter((data) => data.id.indexOf(this.searchText) > -1 || data.name.indexOf(this.searchText) > -1)
            }
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
        },
        electorStatusText(status, electorData) {
            if (status == 'unavaliable') {
                return 'ไม่พร้อมใช้งาน'
            }
            else if (status != 'unavaliable' && electorData != null) {
                return 'เครื่องกำลังใช้งาน'
            }
            else {
                return 'พร้อมใช้งาน'
            }
        },
        electorStatusClass(status, electorData) {
            if (status == 'unavaliable') {
                return 'text-error'
            }
            else if (status != 'unavaliable' && electorData != null) {
                return 'text-warning'
            }
            else {
                return 'text-success'
            }
        },
        electorStatusBool(status, electorData) {
            if (status == 'unavaliable' || (status != 'unavaliable' && electorData != null)) {
                return true
            }
            else {
                return false
            }
        },
        async assignElector(machine, elector) {
            try {
                if (this.findSetting('election_mode') == 'name') {
                    machine.elector_data = elector
                }
                else {
                    machine.elector_data = {
                        vote: null,
                        vote_party: null,
                    }
                }
                machine.elector_status = 'using'
                let res = await axios.put('/api/users/' + machine.id + '/update', machine)
                if (res.statusText == 'OK') {
                    alert('ASSIGN')
                }
                else {

                    alert('ERR')
                }

            }
            catch (err) {
                alert('ERR')
            }
            this.selectedData = null
            this.getNameList()
            this.getUserList()
        },
        async toggleMachineStatus(machine, status = 'unavaliable') {
            try {
                machine.elector_status = status
                if (status == 'unavaliable') {
                    machine.elector_data = null
                }
                let res = await axios.put('/api/users/' + machine.id + '/update', machine)
                if (res.statusText == 'OK') {
                    alert('CHANGE STATUS')
                }
                else {
                    alert('ERR')
                }
            }
            catch (err) {
                alert(err)
            }
            this.getNameList()
            this.getUserList()
        },
        selectUser(user) {
            this.selectedUser = _.cloneDeep(user)
        },
        openModal(id) {
            window.location.href = this.rootUrl + '#' + id
        },
        findSetting(setting) {
            for (let settings of this.settings) {
                if (setting == settings.settings_name) {
                    return settings.value
                }
            }
        },
    },
    watch: {
        studentAmount(newValue) {
            localStorage.setItem('studentAmount', newValue)
        }
    },
    async mounted() {
        await this.getSettings()
        this.getUserList()
        if (this.findSetting('election_mode') == 'name') {
            this.getNameList()
            this.getUserList()
            let intervalData = setInterval(() => {
                this.getNameList()
                this.getUserList()
            }, 5000)
        }
        else {
            let intervalData = setInterval(() => {
                this.getUserList()
                this.getVoteCount()
            }, 2000)
        }
    }
}
</script>
<template>
    <AppLayout title="ลงทะเบียนผู้เลือกตั้ง">
        <div v-if="findSetting('election_mode') == 'name'" class="grid grid-cols-2 gap-3 p-5">
            <div class="bg-white drop-shadow-xl rounded-xl p-5" style="max-height: calc(100vh - 110px);">
                <div class="flex justify-between">
                    <p class="text-4xl text-primary font-bold mb-3">ลงทะเบียนผู้เลือกตั้ง</p>
                    <button class="btn btn-ghost text-gray-500" @click="getNameList(); getUserList()">
                        <span class="material-symbols-rounded mr-1">
                            refresh
                        </span>รีเฟรช</button>
                </div>
                <input type="text" class="input input-bordered w-full mb-3" placeholder="ค้นหารายชื่อที่นี่"
                    v-model="searchText" @input="performSearch()">
                <div class="overflow-auto" style="max-height: calc(100vh - 250px)">
                    <template v-for="data in displayNameList">
                        <button class="btn btn-secondary block p-3 h-fit text-start w-full mb-3"
                            v-if="data.vote == null" @click="selectedData = data">
                            <p class="text-2xl text-primary font-bold">{{ data.id }} - {{ data.name }}</p>
                            <p class="text-primary">ชั้น ม.{{ data.class }}/{{ data.room }}</p>
                        </button>
                    </template>
                </div>
            </div>
            <div class="bg-white rounded-xl drop-shadow-xl p-5">
                <div v-if="selectedData != null">
                    <p class="text-4xl text-primary font-bold mb-5">คุณกำลังเลือก</p>
                    <div class="p-3 bg-yellow-200 rounded-xl mb-5">
                        <p class="text-2xl">เลขประจำตัว: <span class="font-bold">{{ selectedData.id }}</span></p>
                        <p class="text-2xl">ชื่อ: <span class="font-bold">{{ selectedData.name }}</span></p>
                        <p class="text-2xl">ระดับชั้น: <span class="font-bold">{{ selectedData.class }}/{{
                                selectedData.room
                        }}</span></p>
                    </div>
                    <p class="text-4xl text-primary font-bold mb-5">กรุณาเลือกเครื่องเลือกตั้ง</p>
                    <div>
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>ชื่อ</th>
                                    <th>สถานะ</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="user in userList">
                                    <tr v-if="user.role.elector">
                                        <td>{{ user.name }}</td>
                                        <td :class="electorStatusClass(user.elector_status, user.elector_data)">{{
                                                electorStatusText(user.elector_status, user.elector_data)
                                        }}</td>
                                        <td class="flex flex-wrap">
                                            <div class="tooltip mr-3" data-tip="เลือกบัญชีนี้">
                                                <button type="button"
                                                    @click="selectUser(user); openModal('assign-elector-modal')"
                                                    class="btn btn-success"
                                                    :disabled="electorStatusBool(user.elector_status, user.elector_data)"><span
                                                        class="material-symbols-rounded">
                                                        done
                                                    </span></button>
                                            </div>
                                            <div class="tooltip mr-3" data-tip="เปลี่ยนสถานะ">
                                                <button type="button" class="btn btn-warning"
                                                    @click="selectUser(user); openModal('change-status-modal')">
                                                    <span class="material-symbols-rounded">
                                                        priority_high
                                                    </span>
                                                </button>
                                            </div>
                                            <div class="tooltip" data-tip="เปิดใช้งาน"
                                                v-if="user.elector_status == 'unavaliable'">
                                                <button class="btn btn-success"
                                                    @click="selectUser(user); openModal('enable-machine-modal')"><span
                                                        class="material-symbols-rounded">
                                                        power_rounded
                                                    </span></button>
                                            </div>
                                            <div class="tooltip" data-tip="ปิดใช้งาน" v-else>
                                                <button class="btn btn-error"
                                                    @click="selectUser(user); openModal('disable-modal')"><span
                                                        class="material-symbols-rounded">
                                                        close
                                                    </span></button>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="h-full flex flex-col items-center justify-center" v-else>
                    <p class="text-6xl text-center mb-5 text-gray-500">¯\_(ツ)_/¯</p>
                    <p class="text-center text-2xl text-gray-500">คุณยังไม่ได้เลือกผู้เลือกตั้ง</p>
                </div>
            </div>
        </div>

        <!-- NAME MODE -->
        <div class="modal" id="assign-elector-modal" v-if="findSetting('election_mode') == 'name'">
            <div class="modal-box relative" v-if="selectedData != null">
                <div class="flex justify-between items-center">
                    <p class="font-bold text-2xl">เพิ่มผู้เลือกตั้งเข้าเครื่องเลือกตั้ง</p>
                    <a role="button" href="#" class="btn btn-ghost cursor-pointer">✕</a>
                </div>
                <p class="mb-3">โปรดตรวจสอบข้อมูลเหล่านี้ก่อนกดยืนยัน</p>
                <div class="p-3 bg-yellow-200 rounded-xl mb-5">
                    <p>เลขประจำตัว: <span class="font-bold">{{ selectedData.id }}</span></p>
                    <p>ชื่อ: <span class="font-bold">{{ selectedData.name }}</span></p>
                    <p>ระดับชั้น: <span class="font-bold">{{ selectedData.class }}/{{
                            selectedData.room
                    }}</span></p>
                </div>
                <div class="modal-action">
                    <a role="button" href="#" class="btn btn-base">ยกเลิก</a>
                    <a href="#" class="btn btn-success"
                        @click="assignElector(selectedUser, selectedData)">เพิ่มผู้ใช้</a>
                </div>
            </div>
        </div>

        <div class="modal" id="change-status-modal">
            <div class="modal-box relative">
                <div class="flex justify-between items-center">
                    <p class="font-bold text-2xl">เปลี่ยนสถานะ</p>
                    <a role="button" href="#" class="btn btn-ghost cursor-pointer">✕</a>
                </div>
                <label for="edit-status">สถานะ</label>
                <select id="edit-status" class="select select-bordered w-full" v-model="selectedUser.elector_status">
                    <option value="unavaliable">ไม่พร้อมใช้งาน</option>
                    <option value="avaliable">พร้อมใช้งาน</option>
                </select>
                <div class="modal-action">
                    <a role="button" href="#" class="btn btn-base">ยกเลิก</a>
                    <a href="#" class="btn btn-warning" @click="updateUserData(selectedUser)">เปลี่ยนสถานะ</a>
                </div>
            </div>
        </div>
        <div class="modal" id="disable-modal">
            <div class="modal-box relative">
                <div class="flex justify-between items-center">
                    <p class="font-bold text-2xl">ปิดใช้งานเครื่องเลือกตั้ง</p>
                    <a role="button" href="#" class="btn btn-ghost cursor-pointer">✕</a>
                </div>
                <p>คุณแน่ใจหรือไม่ว่าจะปิดใช้งานเครื่องนี้</p>
                <div class="p-3 bg-red-200 rounded-xl mb-5"
                    v-if="selectedUser.elector_status == 'using' && selectedUser.elector_data != null">
                    <p class="text-red-500 font-bold">ตอนนี้กำลังใช้งานเลือกตั้ง</p>
                    <p>เลขประจำตัว: <span class="font-bold">{{ selectedUser.elector_data.id }}</span></p>
                    <p>ชื่อ: <span class="font-bold">{{ selectedUser.elector_data.name }}</span></p>
                    <p>ระดับชั้น: <span class="font-bold">{{ selectedUser.elector_data.class }}/{{
                            selectedUser.elector_data.room
                    }}</span></p>
                </div>
                <div class="modal-action">
                    <a role="button" href="#" class="btn btn-base">ยกเลิก</a>
                    <a href="#" class="btn btn-error" @click="toggleMachineStatus(selectedUser)">ปิดใช้งาน</a>
                </div>
            </div>
        </div>

        <div class="modal" id="enable-machine-modal">
            <div class="modal-box relative">
                <div class="flex justify-between items-center">
                    <p class="font-bold text-2xl">เปิดใช้งานเครื่องเลือกตั้ง</p>
                    <a role="button" href="#" class="btn btn-ghost cursor-pointer">✕</a>
                </div>
                <p>คุณแน่ใจหรือไม่ว่าจะเปิดใช้งานเครื่องนี้</p>
                <div class="modal-action">
                    <a role="button" href="#" class="btn btn-base">ยกเลิก</a>
                    <a href="#" class="btn btn-success"
                        @click="toggleMachineStatus(selectedUser, 'avaliable')">เปิดใช้งาน</a>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
