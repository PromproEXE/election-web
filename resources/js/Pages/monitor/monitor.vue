<script setup>
import axios from 'axios'
import _ from 'lodash'
</script>
<script>
export default {
    data() {
        return {
            nameList: [],
            partyList: []
        }
    },
    methods: {
        async getNameList() {
            try {
                let res = await axios('/api/elector/')
                if (res.statusText == 'OK') {
                    this.nameList = res.data
                }
                else {
                    window.location.reload()
                }
            }
            catch (err) {
                alert(err)
                window.location.reload()
            }
        },
        async getPartyList() {
            try {
                let res = await axios('/api/party/')
                if (res.statusText == 'OK') {
                    this.partyList = res.data
                }
                else {
                    alert('PARTY ERR')
                }
            }
            catch (err) {
                alert(err)
            }
        },
        async sendReport() {
            let status = confirm('คุณแน่ใจหรือไม่ว่าจะทำการส่งและสรุปข้อมูล')

            try {
                if (status == true) {
                    let res = await axios('/api/elector')
                    let elector = res.data

                    let resPost = await axios('https://dev.somsritshirt.com/api/score/create', elector)
                    if (resPost.status == 200) {
                        alert('ส่งข้อมูลแล้ว')
                    }
                    else {
                        alert('ERR')
                    }
                }
            }
            catch (err) {
                console.log(err)
            }
        }
    },
    computed: {
        summaryElector() {
            return this.nameList.length
        },
        votedElector() {
            let voted = 0
            for (let voter of this.nameList) {
                if (voter.vote != null) {
                    voted++
                }
            }

            return voted
        },
        votedList() {
            let voted = this.nameList.filter((data) => data.vote != null && data.vote_party != null)
            voted = _.orderBy(voted, (data) => new Date(data.vote_at), 'desc')
            return voted
        }
    },
    mounted() {
        this.getPartyList()
        let intervalData = setInterval(async => this.getNameList(), 2000)
    }
}
</script>
<template>
    <div class="flex flex-col h-screen p-5">
        <div class="p-3 bg-secondary rounded-xl mb-5">
            <p class="text-4xl text-center text-primary font-bold">มอนิเตอร์</p>
        </div>
        <div class="grid grid-cols-4 gap-5">
            <div>
                <div class="bg-gray-100 p-3 drop-shadow-xl rounded-xl text-center h-fit mb-5">
                    <p class="text-xl mb-3">จำนวนคนที่ลงคะแนนแล้ว</p>
                    <p class="text-6xl font-bold mb-3 text-success">{{ votedElector }} คน</p>
                    <p class="text-xl">จาก {{ summaryElector }} คน</p>
                </div>
                <div class="bg-gray-100 p-3 drop-shadow-xl rounded-xl text-center h-fit mb-5">
                    <p class="text-xl mb-3">จำนวนผู้ที่ยังไม่ได้ลงคะแนน</p>
                    <p class="text-6xl font-bold mb-3 text-error">{{ summaryElector - votedElector }} คน</p>
                </div>
                <button class="btn btn-warning w-full text-xl h-fit" @click="sendReport()"><span
                        class="material-symbols-rounded mr-1">
                        done
                    </span>
                    สรุปและส่งผลคะแนน</button>
            </div>
            <div class="col-span-3 overflow-auto">
                <div class="p-4 bg-secondary rounded-xl mb-5" v-for="voter in votedList">
                    <p class="text-4xl text-primary font-bold">{{ voter.id }} - {{ voter.name }}</p>
                    <p class="text-xl">ระดับชั้น: ม.{{ voter.class }}/{{ voter.room }}</p>
                    <small>เมื่อ {{ new Date(voter.vote_at).toLocaleDateString('th-TH') }} เวลา {{ new
                            Date(voter.vote_at).toLocaleTimeString('th-TH')
                    }}</small>
                </div>
            </div>
        </div>
    </div>
</template>
