<script setup>
import axios from 'axios';
import _ from 'lodash'
</script>
<script>
export default {
    data() {
        return {
            machineStatus: 'unavaliable',
            electorData: {},
            settings: [],

            userData: {},
            partyName: [],
            voted: true,
        }
    },
    methods: {
        async getPartyData() {
            try {
                let res = await axios('/api/party/')
                if (res.statusText == 'OK') {
                    this.partyName = res.data
                    this.partyName = _.sortBy(this.partyName, 'party_number')
                }
                else {
                    console.log('GET PARTY ERROR')
                }
            }
            catch (err) {
                alert(err)
            }
        },
        async getUserData() {
            let intervalData = setInterval(async () => {
                this.machineStatus = 'avaliable'
                try {
                    let res = await axios('/api/users/me')
                    if (res.statusText == 'OK') {
                        this.machineStatus = res.data.elector_status
                        this.electorData = res.data.elector_data

                        if (this.machineStatus == 'using') {
                            // await this.getPartyData()
                            const controller = new AbortController();
                            this.userData = res.data
                            controller.abort()
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
            }, 5000)
        },
        async getSetting() {
            let res = await axios('/api/settings')
            this.settings = res.data
        },
        findSetting(setting) {
            for (let settings of this.settings) {
                if (setting == settings.settings_name) {
                    return settings.value
                }
            }
        },
        async confirmVote() {
            this.machineStatus = 'process'
            try {
                if (this.findSetting('election_mode') == 'name') {
                    //ELECTOR
                    let updateElector = await axios.put('/api/elector/' + this.electorData.id + '/update', this.electorData)
                    if (updateElector.statusText != 'OK') {
                        alert('VOTE ERROR')
                        return
                    }

                    //MACHINE
                    this.userData.elector_status = 'avaliable'
                    this.userData.elector_data = null
                    let updateUser = await axios.put('/api/users/' + this.userData.id + '/update', this.userData)
                    if (updateUser.statusText != 'OK') {
                        alert('VOTE ERROR')
                        return
                    }
                }
                else {
                    //ELECTOR
                    let addElector = await axios.post('/api/vote_count/create', this.electorData)
                    if (addElector.statusText != 'OK') {
                        alert('VOTE ERROR')
                        return
                    }

                    //MACHINE
                    this.userData.elector_status = 'avaliable'
                    this.userData.elector_data = null
                    let updateUser = await axios.put('/api/users/' + this.userData.id + '/update', this.userData)
                    if (updateUser.statusText != 'OK') {
                        alert('VOTE ERROR')
                        return
                    }
                }

                //CHANGE STATUS
                this.machineStatus = 'success'
                this.voted = true

                setTimeout(this.getUserData(), 3500)


            }
            catch (err) {
                console.log(err)
            }
        },
        selectVote(vote, voteParty) {
            this.electorData.vote = String(vote)
            this.electorData.vote_party = voteParty
        }
    },
    async mounted() {
        await this.getSetting()
        this.getPartyData()
        if (this.findSetting('election_mode') == 'name') {
            this.getUserData()
            window.addEventListener("keypress", (e) => {
                console.log(e.key)
                if (this.electorData.vote == null && this.electorData.vote_party == null) {
                    if (!Number.isInteger(parseInt(e.key))) {
                        if (!this.electorData.vote) {
                            this.selectVote(0, 'ไม่ประสงค์ลงคะแนน')
                        }
                    }
                    else {
                        if (e.key >= 0 && e.key <= this.partyName.length) {
                            if (e.key == 0) {
                                this.selectVote(0, 'ไม่ประสงค์ลงคะแนน')
                            }
                            else {
                                for (let party of this.partyName) {
                                    if (party.party_number == e.key) {
                                        this.selectVote(e.key, party.party_name)
                                    }
                                }
                            }
                        }
                    }
                }

                if (this.electorData.vote) {
                    if (e.key == 'Enter') {
                        this.electorData.vote_at = new Date().toISOString()
                        this.confirmVote()
                    }

                    if (e.key == '-') {
                        this.electorData.vote = null
                        this.electorData.vote_party = null
                    }
                }
            });
        }
        else {
            this.getUserData()
            window.addEventListener("keypress", (e) => {
                console.log(e.key)
                if (!Number.isInteger(parseInt(e.key))) {
                    if (!this.electorData.vote) {
                        this.selectVote(e.key, party)
                    }
                }
                else {
                    if (e.key >= 0 && e.key <= this.partyName.length) {
                        if (e.key == 0) {
                            this.selectVote(e.key, party)
                        }
                        else {
                            for (let party of this.partyName) {
                                if (party.party_number == e.key) {
                                    this.selectVote(e.key, party.party_name)
                                }
                            }
                        }
                    }
                }

                if (this.electorData.vote) {
                    if (e.key == 'Enter') {
                        this.electorData.vote_at = new Date().toISOString()
                        this.confirmVote()
                    }

                    if (e.key == '-') {
                        this.electorData.vote = null
                    }
                }
            });
        }
    }
}
</script>
<template>
    <div class="h-screen p-5" :class="{
        'bg-error items-center justify-center flex flex-col ': machineStatus == 'unavaliable',
        'bg-info items-center justify-center flex flex-col ': machineStatus == 'avaliable',
        'bg-warning items-center justify-center flex flex-col ': machineStatus == 'process',
        'bg-success items-center justify-center flex flex-col ': machineStatus == 'success' && voted
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
        <div class="text-center" v-if="machineStatus == 'process'">
            <div class="radial-progress loader mb-5" style="--value:70;"></div>
            <p class="text-gray-700 text-2xl text-center font-bold">ระบบกำลังบันทึกคะแนนของคุณ</p>
            <p class="text-gray-700 text-xl text-center">กรุณารอสักครู่</p>
        </div>
        <div class="text-center" v-if="machineStatus == 'success' && voted">
            <span class="material-symbols-rounded" style="font-size: 12rem;">
                done
            </span>
            <p class="text-gray-700 text-4xl text-center font-bold">ลงคะแนนสำเร็จ</p>
            <p class="text-gray-700 text-2xl text-center">กรุณาเดินออกจากคูหาโดยทันที</p>
        </div>

        <!-- NAME MODE -->
        <div class="p-3 bg-secondary text-center rounded-xl mb-5"
            v-if="machineStatus == 'using' && electorData != null && findSetting('election_mode') == 'name'">
            <p class="text-4xl text-primary font-bold">ระบบลงคะแนน</p>
        </div>
        <div class="grid grid-cols-3 gap-5"
            v-if="machineStatus == 'using' && electorData != null && findSetting('election_mode') == 'name'">
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
                    <button class="btn btn-secondary text-center block w-full h-full py-6" v-for="party in partyName"
                        @click="selectVote(party.party_number, party.party_name)">
                        <p class="text-6xl">{{ party.party_number }}</p>
                        <p>{{ party.party_name }}</p>
                    </button>
                    <button class="btn btn-secondary text-center block w-full h-full py-6"
                        @click="selectVote('0', 'ไม่ประสงค์ลงคะแนน')">
                        <p class="text-6xl">0</p>
                        <p class="">ไม่ประสงค์ลงคะแนน</p>
                    </button>
                </div>
            </div>
            <div class="">
                <div class="bg-gray-200 rounded-xl p-3 text-center">
                    <p class="mb-2 text-xl font-bold">ตอนนี้คุณกำลังเลือกเบอร์</p>
                    <p class="text-error text-9xl font-bold">{{ electorData.vote || '-' }}</p>
                    <p class="text-error text-2xl font-bold">{{ electorData.vote_party || 'ไม่ได้เลือก' }}</p>
                </div>
            </div>
            <div class="col-span-2">
                <p class="text-center text-4xl font-bold mb-3">กรุณายืนยันหมายเลขที่เลือก</p>
                <div class="grid grid-cols-2 gap-5 h-full">
                    <button class="btn btn-success block h-fit py-5 w-full" :disabled="electorData.vote == null">
                        <p class="text-3xl">ยืนยัน</p>
                        <p class="text-xl">(กดปุ่ม Enter)</p>
                    </button>
                    <button class="btn btn-error w-full block py-5 h-fit" :disabled="electorData.vote == null">
                        <p class="text-3xl">ไม่ยืนยัน</p>
                        <p class="text-xl">(กดปุ่ม -)</p>
                    </button>
                </div>
            </div>
        </div>

        <!-- NUMBER MODE -->
        <div class="grid grid-cols-3 gap-5 h-full overflow-auto"
            v-if="machineStatus == 'using' && findSetting('election_mode') == 'number_only'">
            <div class="col-span-2">
                <div class="bg-warning p-3 mb-5 rounded-xl">
                    <p class="text-2xl font-bold text-center">พรรคที่สามารถเลือกได้</p>
                </div>
                <div class="grid grid-cols-3 gap-5 h-100">
                    <button class="btn btn-secondary text-center block w-full h-full py-6" v-for="party in partyName"
                        @click="selectVote(party.party_number, party.party_name)">
                        <p class="text-6xl">{{ party.party_number }}</p>
                        <p>{{ party.party_name }}</p>
                    </button>
                    <button class="btn btn-secondary text-center block w-full h-full py-6"
                        @click="selectVote('0', 'ไม่ประสงค์ลงคะแนน')">
                        <p class="text-6xl">0</p>
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
                    <button class="btn btn-success block h-fit py-5 w-full" :disabled="electorData.vote == null">
                        <p class="text-3xl">ยืนยัน</p>
                        <p class="text-xl">(กดปุ่ม Enter)</p>
                    </button>
                    <button class="btn btn-error w-full block py-5 h-fit" :disabled="electorData.vote == null">
                        <p class="text-3xl">ไม่ยืนยัน</p>
                        <p class="text-xl">(กดปุ่ม -)</p>
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
