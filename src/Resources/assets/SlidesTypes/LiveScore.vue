<template>
    <div class="container tw-bg-gray-200 montserrat">
        <div v-if="ready">
            <div v-if="isLive" class="tw-flex tw-flex-col">
                <div class="tw-flex tw-mt-4 tw-mb-8 tw-shadow-lg">
                    <div class="tw-w-1/2 tw-text-white tw-p-4 tw-font-bold tw-uppercase tw-text-4xl tw-flex tw-items-center tw-justify-end" :style="{background: live.home_team.color}">
                        <div v-if="live.can_home_tactical" class="tw-bg-black tw-text-white tw-rounded-full tw-mr-4 tw-py-1 tw-px-4">CT <i class="fa fa-check"></i></div>
                        <div>{{ live.home_team.name }}</div>
                        <img class="tw-float-left tw-h-24 tw-pl-6 tw-pr-4" :src="live.home_team.logo_url" alt="" />
                    </div>
                    <div class="tw-bg-white tw-px-8 tw-font-bold tw-flex tw-items-center tw-justify-center tw-text-6xl tw-w-1/5">
                        <div class="tw-w-1/2 tw-text-center"
                            :class="{'tw-text-green-600': live.has_home_won}">
                            {{ live.home_team_points }}
                        </div>
                        <div class="tw-px-2 tw-text-gray-500">-</div>
                        <div class="tw-w-1/2 tw-text-center"
                            :class="{'tw-text-green-600': live.has_visitors_won}">
                            {{ live.visitors_team_points }}
                        </div>
                    </div>
                    <div class="tw-w-1/2 tw-text-white tw-p-4 tw-font-bold tw-uppercase tw-text-4xl tw-flex tw-items-center tw-justify-start" :style="{background: live.visitors_team.color}">
                        <img class="tw-float-left tw-h-24 tw-pr-6 tw-pl-4" :src="live.visitors_team.logo_url" alt="" />
                        <div>{{ live.visitors_team.name }}</div>
                        <div v-if="live.can_visitors_tactical" class="tw-bg-black tw-text-white tw-rounded-full tw-ml-4 tw-py-1 tw-px-4">CT <i class="fa fa-check"></i></div>
                    </div>
                </div>

                <div class="tw-flex tw-mx-4">
                    <div class="tw-w-1/2 tw-mr-2">
                        <Riders :riders="live.home_riders" />
                    </div> 
                    <div class="tw-w-1/2 tw-ml-2">
                        <Riders :riders="live.visitors_riders" />
                    </div> 
                </div>

                <div class="tw-h-40">
                    <div v-if="lastHeat" class="tw-flex tw-flex-col">
                        <div class="tw-pl-32 tw-ml-8">
                            Dernière manche <small class="tw-opacity-25">Last Heat</small>
                        </div>
                        <div class="tw-bg-white tw-shadow tw-p-4 tw-flex tw-items-center tw-h-24">
                            <div class="tw-h-32 tw-w-24 tw-mr-4 tw-bg-gray-700 tw-text-white tw-font-bold tw-rounded-lg tw-flex tw-items-center tw-justify-center tw-text-5xl tw-leading-none">
                                M{{ lastHeat.number }}
                            </div>

                            <div class="tw-flex tw-justify-stretch tw-rounded-lg tw-shadow tw-mr-2" v-for="r of lastHeat.riders">
                                <div class="tw-w-4 tw-rounded-l-lg" :class="`tw-bg-${r.pivot.helmet_color}-500`"></div>
                                <div class="tw-py-2 tw-px-4 tw-bg-gray-100 tw-text-2xl tw-flex tw-items-center"
                                    :class="{'tw-text-green-600': r.pivot.replacement_rider_id}">
                                    {{ r.info.number }}. {{ r.name }}
                                    <i class="fa fa-sync tw-ml-2" v-if="r.pivot.replacement_rider_id"></i>
                                </div>
                                <div class="tw-py-2 tw-px-2 tw-bg-gray-900 tw-text-white tw-text-2xl tw-flex tw-items-center"
                                    v-if="r.pivot.ct">
                                    CT
                                </div>
                                <div class="tw-py-2 tw-px-4 tw-text-white tw-rounded-r-lg tw-text-3xl tw-flex tw-items-center"
                                    :class="{'tw-bg-red-600': isNaN(r.pivot.points), 'tw-bg-gray-600': !isNaN(r.pivot.points)}">
                                    {{ r.pivot.points }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="tw-h-40">
                    <div v-if="nextHeat" class="tw-flex tw-flex-col">
                        <div class="tw-pl-32 tw-ml-8">
                            Manche suivante <small class="tw-opacity-25">Next Heat</small>
                        </div>
                        <div class="tw-bg-white tw-shadow tw-p-4 tw-flex tw-items-center tw-h-24">
                            <div class="tw-h-32 tw-w-24 tw-mr-4 tw-bg-gray-700 tw-text-white tw-font-bold tw-rounded-lg tw-flex tw-items-center tw-justify-center tw-text-5xl tw-leading-none">
                                M{{ nextHeat.number }}
                            </div>

                            <div class="tw-flex tw-justify-stretch tw-rounded-lg tw-shadow tw-mr-2" v-for="r of nextHeat.riders">
                                <div class="tw-w-4 tw-rounded-l-lg" :class="`tw-bg-${r.pivot.helmet_color}-500`"></div>
                                <div class="tw-py-2 tw-px-4 tw-bg-gray-100 tw-text-2xl tw-flex tw-items-center"
                                    :class="{'tw-text-green-600': r.pivot.replacement_rider_id}">
                                    {{ r.info.number }}. {{ r.name }}
                                    <i class="fa fa-sync tw-ml-2" v-if="r.pivot.replacement_rider_id"></i>
                                </div>
                                <div class="tw-py-2 tw-px-2 tw-bg-gray-900 tw-text-white tw-text-2xl tw-flex tw-items-center"
                                    v-if="r.pivot.ct">
                                    CT
                                </div>
                                <div class="tw-py-2 tw-px-4 tw-bg-gray-400 tw-text-gray-600 tw-rounded-r-lg tw-text-2xl tw-flex tw-items-center">
                                    {{ r.pivot.gate }}
                                </div>
                            </div>

                        </div>
                    </div>
                    <div v-else-if="showClassificationResults">
                        <div class="tw-flex tw-mt-4 tw-mb-8 tw-shadow-lg">
                            <div class="tw-w-1/2 tw-text-white tw-p-4 tw-font-bold tw-uppercase tw-text-4xl tw-flex tw-items-center tw-justify-end" :style="{background: live.home_team.color}">
                                <div>{{ live.home_team.name }}</div>
                                <img class="tw-float-left tw-h-24 tw-pl-6 tw-pr-4" :src="live.home_team.logo_url" alt="" />
                            </div>
                            <div class="tw-bg-white tw-px-8 tw-font-bold tw-flex tw-items-center tw-justify-center tw-text-6xl tw-w-1/5">
                                <div class="tw-w-1/2 tw-text-orange-500 tw-text-center">
                                    {{ live.home_classification_points }}
                                </div>
                                <div class="tw-px-2 tw-text-orange-300">-</div>
                                <div class="tw-w-1/2 tw-text-orange-500 tw-text-center">
                                    {{ live.visitors_classification_points }}
                                </div>
                            </div>
                            <div class="tw-w-1/2 tw-text-white tw-p-4 tw-font-bold tw-uppercase tw-text-4xl tw-flex tw-items-center tw-justify-start" :style="{background: live.visitors_team.color}">
                                <img class="tw-float-left tw-h-24 tw-pr-6 tw-pl-4" :src="live.visitors_team.logo_url" alt="" />
                                <div>{{ live.visitors_team.name }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                

            </div>
            <div v-else-if="next_match" class="tw-flex tw-flex-col">
                <div class="tw-pt-16 tw-pb-8">
                    <LogoLns />
                </div>
                <div class="tw-py-4 tw-text-center tw-text-gray-800">
                    PROCHAIN MATCH
                </div>
                <div class="tw-flex tw-mx-16 tw-h-32 tw-rounded-lg tw-shadow-lg">
                    <div class="tw-w-1/2 tw-text-white tw-p-4 tw-font-bold tw-rounded-l-lg tw-uppercase tw-text-5xl" :style="{background: next_match.home_team.color}">
                        <img class="tw-float-left tw-w-64" :src="next_match.home_team.logo_url" alt="" />
                        <div class="tw-h-full tw-flex tw-items-center tw-justify-end">
                            <div>{{ next_match.home_team.name }}</div>
                        </div>
                    </div>
                    <div class="tw-bg-white tw-px-8 tw-font-bold tw-flex tw-items-center tw-text-5xl">
                        <div>VS</div>
                    </div>
                    <div class="tw-w-1/2 tw-text-white tw-p-4 tw-font-bold tw-rounded-r-lg tw-uppercase tw-text-5xl" :style="{background: next_match.visitors_team.color}">
                        <img class="tw-float-right tw-w-64" :src="next_match.visitors_team.logo_url" alt="" />
                        <div class="tw-h-full tw-flex tw-items-center tw-justify-start">
                            <div>{{ next_match.visitors_team.name }}</div>
                        </div>
                    </div>
                </div>
                <div v-if="isNextMatchToday" class="tw-mt-32 tw-flex-col tw-items-center">
                    <div class="tw-flex tw-justify-center">
                        
                        <div class="tw-w-56 tw-text-center tw-flex tw-flex-col tw-items-center">
                            <div class="tw-font-bold" style="font-size: 8rem;">{{ countdown_h }}</div>
                            <div class="tw-text-3xl">heures</div>
                        </div>
                        <div class="tw-w-56 tw-text-center tw-flex tw-flex-col tw-items-center">
                            <div class="tw-font-bold" style="font-size: 8rem;">{{ countdown_m }}</div>
                            <div class="tw-text-3xl">minutes</div>
                        </div>
                        <div class="tw-w-56 tw-text-center tw-flex tw-flex-col tw-items-center">
                            <div class="tw-font-bold" style="font-size: 8rem;">{{ countdown_s }}</div>
                            <div class="tw-text-3xl">secondes</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            Chargement...    
        </div>
    </div>
</template>

<script>
import moment from "moment";
import LogoLns from "../components/LogoLns";
import Riders from "../components/Riders";

    export default {
        props: ['slide'],
        components: {
            LogoLns, Riders
        },
        data: function () {
            return {
              live: null,
              isLive: false,
              lastHeat: null,
              nextHeat: null,
              showClassificationResults: false,

              next_match: null,
              now: Math.trunc((new Date()).getTime() / 1000),
              isNextMatchToday: false,
              countdown_h: 0,
              countdown_m: 0,
              countdown_s: 0,
              
              updateIntervalHandle: null,
              countdownIntervalHandle: null,
            };
        },
        computed: {
            ready: () => this.live !== null,
        },
        methods: {
            updateData() {
                fetch(this.slide.data.api_url + "matches/live").then(async resp => {
                    let json = await resp.json();

                    if (!("id" in json)) {
                        fetch(this.slide.data.api_url + "matches").then(async resp => {
                            let matches = await resp.json();
                            matches = matches.filter(m => {
                                m.date = moment(m.date);
                                return m.date.isAfter(moment());
                            });
                            this.next_match = matches.shift();
                            if (!this.next_match) {
                                return;
                            }
                            this.isNextMatchToday = this.next_match.date.isSame(new Date, "day");
                        });
                    } else {
                        this.isLive = true;

                        let riders = {};

                        for (let r of json.home_riders) {
                            r.heats = {};
                            r.total = 0;
                            riders[r.id] = r;
                        }
                        for (let r of json.visitors_riders) {
                            r.heats = {};
                            r.total = 0;
                            riders[r.id] = r;
                        }

                        for (let h of json.heats) {
                            for (let r of h.riders) {
                                let rider = riders[r.id];
                                rider.heats[h.id] = r.pivot;
                                r.info = rider.pivot;
                                rider.total += (Number.parseInt(r.pivot.real_points) || 0);
                            }

                            let done = h.riders.filter(r => !!r.pivot.points).length > 0;
                            
                            if (done) {
                                this.lastHeat = h;
                            }
                        }

                        let lastHeatId = 0;
                        if (this.lastHeat) {
                            lastHeatId = this.lastHeat.number;

                            this.lastHeat.riders.sort((a, b) => {
                                if (isNaN(a.pivot.points) && !isNaN(b.pivot.points)) {
                                    return 1;
                                }
                                if (!isNaN(a.pivot.points) && isNaN(b.pivot.points)) {
                                    return -1;
                                }

                                if (a.pivot.real_points > b.pivot.real_points) {
                                    return -1;
                                } else if (a.pivot.real_points < b.pivot.real_points) {
                                    return 1;
                                }
                                return 0;
                            });
                        }

                        this.showClassificationResults = false;
                        if (lastHeatId == 14) {
                            this.showClassificationResults = true;
                        }

                        json.heats.filter(h => h.number == lastHeatId + 1).map(h => this.nextHeat = h);

                        let sortRiders = (a, b) => {
                            if (a.total > b.total) {
                                return -1;
                            } else if (a.total < b.total) {
                                return 1;
                            }
                            return 0;
                        };

                        json.home_riders.sort(sortRiders);
                        json.visitors_riders.sort(sortRiders);


                    }

                    this.live = json;
                });
            },
            twoDigits(value) {
                if (value < 0) {
                    return '00';
                }
                if (value.toString().length <= 1) {
                    return `0${value}`;
                }
                return value;
            },
        },
        activated() {
            console.log("LNS activated");
            this.updateData();
            // this.updateIntervalHandle = setInterval(() =>  this.updateData(), 60 * 1000);
            this.countdownIntervalHandle = setInterval(() => {
                if (!this.next_match || !this.next_match.id) {
                    return;
                }
                let now = Math.trunc((new Date()).getTime() / 1000);
                let ms = this.next_match.date.unix();
                this.countdown_s = this.twoDigits((ms - now) % 60);
                this.countdown_m = this.twoDigits(Math.trunc((ms - now) / 60) % 60);
                this.countdown_h = this.twoDigits(Math.trunc((ms - now) / 60 / 60) % 24);
            },1000);
        },
        deactivated() {
            console.log("LNS deactivated");
            clearInterval(this.updateIntervalHandle);
            clearInterval(this.countdownIntervalHandle);
        }
    }
</script>

<style scoped>
   

</style>

<style>
    @import url('https://fonts.googleapis.com/css?family=Montserrat&display=swap');

    .montserrat {
        font-family: 'Montserrat', sans-serif;
    }
</style>
