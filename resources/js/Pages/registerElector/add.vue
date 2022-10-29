<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import InputFile from '../../Components/inputFile.vue';
import axios from 'axios'
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
        readCsvFile() {
            let CSVFile = document.getElementById('list-upload').files[0]
            const reader = new FileReader()

            //READ FILE
            let CSVText = reader.readAsText(CSVFile)

            //GET LIST
            reader.onload = (e) => {
                const text = e.target.result;
                let nameArr = text.split('\n')
                let fullClass = nameArr[0].split(',')[0]
                let classes = fullClass.split('/')[0]
                let room = fullClass.split('/')[1]
                nameArr.splice(0, 1)

                //CLEAN DATA
                nameArr = nameArr.map((data) => data.replace('\r', '') && data.split(','))

                this.nameList = []
                for (let data of nameArr) {
                    if (data[0] == '' || data[1] == '') continue
                    this.nameList.push({
                        id: data[0],
                        name: data[1],
                        class: classes,
                        room: room
                    })
                }
            };
        },
        async uploadNameList() {
            try {
                let res = await axios.post('/api/elector/create', this.nameList)
                console.log(res)
                alert('อัปโหลดรายชื่อแล้ว')
                this.nameList = []
                document.getElementById('list-upload').value = null
            }
            catch (err) {
                alert('อัปโหลดรายชื่อไม่สำเร็จ')
            }
        }
    }
}
</script>
<template>
    <AppLayout title="เพิ่มผู้มีสิทธิ์เลือกตั้ง">
        <div class="grid grid-cols-2 gap-3 p-3">
            <div class="bg-white drop-shadow-xl rounded-xl p-7">
                <h1 class="text-primary text-5xl font-bold mb-3">เพิ่มผู้มีสิทธิ์เลือกตั้ง</h1>
                <p class="mb-3">เพิ่มผู้มีสิทธิ์เลือกตั้งหรือลบผู้มีสิทธิ์เลือกตั้ง โดยการเพิ่มจะต้องมี<span
                        class="font-bold"><a href="/" class="link link-primary">รูปแบบไฟล์นี้</a></span></p>
                <p class="text-gray-500">เพิ่มไฟล์รายชื่อ (.csv)</p>
                <form @submit.prevent="uploadNameList()">
                    <InputFile id="list-upload" class="mb-4" @input="readCsvFile()" accept=".csv" :multiple="true">
                    </InputFile>
                    <div class="grid grid-cols-2 gap-3">
                        <button class="btn btn-success w-100 text-xl" type="submit">อัปโหลดรายชื่อ</button>
                        <button class="btn btn-error w-100 text-xl" type="reset">รีเซ็ต</button>
                    </div>
                </form>
            </div>
            <div class="bg-white drop-shadow-xl rounded-xl p-7">
                <h1 class="text-primary text-5xl font-bold mb-3">รายชื่อที่จะทำการอัปโหลด</h1>

                <!-- LIST -->
                <div class="bg-secondary text-primary rounded-xl drop-shadow-xl p-4 flex justify-between mb-3"
                    v-for="(data, i) in nameList">
                    <div class="flex items-center">
                        <h1 class="text-5xl font-bold mr-3">{{ i + 1 }}</h1>
                        <div>
                            <p class="font-bold text-xl">ชื่อ: {{ data.name }}</p>
                            <p>ชั้น: ม.{{ data.class }}/{{ data.room }}</p>
                        </div>
                    </div>
                    <div>
                        <div class="tooltip" data-tip="แก้ไข">
                            <a role="button" href="#edit-modal" class="btn btn-warning mr-3 font-bold"
                                @click="selectedData = data">
                                <span class="material-symbols-rounded">edit</span>
                            </a>
                        </div>
                        <div class="tooltip" data-tip="ลบ">
                            <button class="btn btn-error font-bold" @click="nameList.splice(i, 1)">
                                <span class="material-symbols-rounded">delete</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" tabindex="-1" id="edit-modal">
            <div class="modal-box">
                <a href="#" role="button" class="btn btn-circle btn-ghost absolute right-2 top-3">✕</a>
                <p class="font-bold text-2xl">แก้ไขข้อมูล</p>
                <label for="edit-id" class="label">
                    <h6>เลขประจำตัว</h6>
                </label>
                <input type="text" id="edit-id" class="input input-bordered w-full" v-model="selectedData.id">
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
                    <a class="btn btn-success" href="#">บันทึก</a>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
