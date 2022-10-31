<script setup>
import { createFunctionExpression } from '@vue/compiler-core';
import axios from 'axios';
</script>
<script>
export default {
    data() {
        return {
            machineStatus: 'unavaliable',
            electorData: {},
            userData: {},
            partyName: [{
                party_number: 1,
                party_name: 'กาญจนาก้าวหน้า'
            }],
            voted: true,
        }
    },
    methods: {
        getUserData() {
            let intervalData = setInterval(async () => {
                try {
                    let res = await axios('/api/users/me')
                    if (res.statusText == 'OK') {
                        this.machineStatus = res.data.elector_status
                        this.electorData = res.data.elector_data

                        if (this.machineStatus == 'using') {
                            this.userData = res.data
                            clearInterval(intervalData)
                        }
                    }
                    else {
                        window.location.reload()
                    }
                }
                catch (err) {
                    window.location.reload()
                }
            }, 2000)
        },
        async confirmVote() {
            try {
                //ELECTOR
                let updateElector = await axios.put('/api/elector/' + this.electorData.id + '/update', this.electorData)
                if (updateElector.statusText != 'OK') {
                    alert('VOTE ERROR')
                }

                //MACHINE
                this.userData.elector_status = 'avaliable'
                this.userData.elector_data = null
                let updateUser = await axios.put('/api/users/' + this.userData.id + '/update', this.userData)
                if (updateUser.statusText != 'OK') {
                    alert('VOTE ERROR')
                }

                //CHANGE STATUS
                this.machineStatus = 'success'
                this.voted = true

                setTimeout(this.getUserData(), 5000)
            }
            catch (err) {
                console.log(err)
            }
        }
    },
    mounted() {
        this.getUserData()
        window.addEventListener("keypress", (e) => {
            console.log(e.key)
            if (!Number.isInteger(parseInt(e.key))) {
                if (!this.electorData.vote) {
                    this.electorData.vote = '0'
                }
            }
            else {
                this.electorData.vote = e.key
            }
            if (this.electorData.vote) {
                if (e.key == 'Enter') {
                    this.confirmVote()
                }

                if (e.key == '-') {
                    this.electorData.vote = null
                }
            }
        });
    }
}
</script>
<template>
    <div class="flex flex-col h-screen p-5" :class="{
        'bg-error items-center justify-center': machineStatus == 'unavaliable',
        'bg-info items-center justify-center': machineStatus == 'avaliable',
        'bg-success items-center justify-center': machineStatus == 'success' && voted
    }">
        <div v-if="machineStatus == 'unavaliable'">
            <p class="text-red-500 text-center"><span class="material-symbols-rounded text-9xl">
                    close
                </span></p>
            <p class="text-gray-700 text-2xl text-center font-bold">เครื่องถูกปิดใช้งานอยู่</p>
        </div>
        <div class="text-center" v-if="machineStatus == 'avaliable'">
            <div class="radial-progress loader mb-5" style="--value:70;"></div>
            <p class="text-gray-700 text-2xl text-center font-bold">เครื่องพร้อมใช้งาน</p>
            <p class="text-gray-700 text-xl text-center">กรุณารอสักครู่</p>
        </div>
        <div class="text-center" v-if="machineStatus == 'success' && voted">
            <span class="material-symbols-rounded" style="font-size: 12rem;">
                done
            </span>
            <p class="text-gray-700 text-4xl text-center font-bold">ลงคะแนนสำเร็จ</p>
            <p class="text-gray-700 text-2xl text-center">กรุณาเดินออกจากคูหาโดยทันที</p>
        </div>
        <div class="p-3 bg-secondary text-center rounded-xl mb-5"
            v-if="machineStatus == 'using' && electorData != null">
            <p class="text-4xl text-primary font-bold">ระบบลงคะแนน</p>
        </div>
        <div class="grid grid-cols-3 gap-5 h-full overflow-auto" v-if="machineStatus == 'using' && electorData != null">
            <div class="p-3 bg-gray-200 rounded-xl">
                <p class="text-2xl font-bold">เลขประจำตัวนักเรียน:</p>
                <p class="text-4xl mb-5">{{ electorData.id }}</p>
                <p class="text-2xl font-bold">ชื่อ-นามสกุล:</p>
                <p class="text-4xl mb-5">{{ electorData.name }}</p>
                <p class="text-2xl font-bold">ระดับชั้น:</p>
                <p class="text-4xl">{{ electorData.class }}/{{ electorData.room }}</p>
            </div>
            <div class="col-span-2">
                <div class="bg-warning p-3 mb-5 rounded-xl">
                    <p class="text-2xl font-bold text-center">พรรคที่สามารถเลือกได้</p>
                </div>
                <div class="grid grid-cols-3 gap-5 h-100">
                    <button class="btn btn-secondary text-center block w-full h-full py-6" v-for="n in 6">
                        <p class="text-6xl">{{ n }}</p>
                        <p class="">พรรคกาญจนาก้าวหน้า</p>
                    </button>
                    <button class="btn btn-secondary text-center block w-full h-full py-6">
                        <p class="text-6xl">{{ 0 }}</p>
                        <p class="">ไม่ประสงค์ลงคะแนน</p>
                    </button>
                </div>
            </div>
            <div class="h-full">
                <div class="bg-gray-200 rounded-xl p-3 text-center h-full">
                    <p class="mb-2 text-xl font-bold">ตอนนี้คุณกำลังเลือกเบอร์</p>
                    <p class="text-error text-9xl font-bold">{{ electorData.vote || '-' }}</p>
                </div>
            </div>
            <div class="col-span-2 h-full">
                <p class="text-center text-4xl font-bold mb-3">กรุณายืนยันหมายเลขที่เลือก</p>
                <div class="grid grid-cols-2 gap-5 h-full">
                    <button class="btn btn-success w-full" :disabled="electorData.vote == null">
                        <p class="text-3xl">ยืนยัน</p>
                    </button>
                    <button class="btn btn-error w-full" :disabled="electorData.vote == null">
                        <p class="text-3xl">ไม่ยืนยัน</p>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}

.loader {
    animation: spin 2s linear infinite;
}
</style>
