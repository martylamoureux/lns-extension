<template>
    <div class="container tw-bg-gray-200 montserrat">
        <div v-if="ready">
            <div v-if="isLive" class="tw-flex tw-flex-col">
                <div class="tw-flex tw-mt-4 tw-mb-8 tw-shadow-lg" v-if="live.is_lns">
                    <div class="tw-w-1/2 tw-text-white tw-p-4 tw-font-bold tw-uppercase tw-text-4xl tw-flex tw-items-center tw-justify-end" :style="{background: live.home_team.color}">
                        <div v-if="live.can_home_tactical && nextHeat && nextHeat.allow_tactical" class="tw-bg-black tw-text-white tw-rounded-full tw-mr-4 tw-py-1 tw-px-4">CT <i class="fa fa-check"></i></div>
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
                        <div v-if="live.can_visitors_tactical && nextHeat && nextHeat.allow_tactical" class="tw-bg-black tw-text-white tw-rounded-full tw-ml-4 tw-py-1 tw-px-4">CT <i class="fa fa-check"></i></div>
                    </div>
                </div>

                <div class="tw-flex tw-mx-4" v-if="live.is_lns">
                    <div class="tw-w-1/2 tw-mr-2">
                        <Riders :riders="live.home_riders" />
                    </div> 
                    <div class="tw-w-1/2 tw-ml-2">
                        <Riders :riders="live.visitors_riders" />
                    </div> 
                </div>
                <div class="tw-flex tw-flex-wrap tw-mx-4 tw-mt-10" v-else-if="live.is_promotion_cup">
                    <div class="tw-w-1/2 tw-pr-2">
                        <div class="tw-bg-red-700 tw-mb-4 tw-px-2 tw-rounded-lg tw-text-white tw-h-12 tw-flex tw-items-center tw-text-3xl">
                            <img class="tw--mt-10 tw-h-20 tw-mr-4" :src="live.red_team.logo_url" alt="">
                            <div class="tw-flex-grow">
                                {{ live.red_team.name }}
                            </div>
                            <div class="tw-bg-white tw-leading-none tw-py-1 tw-rounded-lg tw-text-black tw-text-center tw-w-24">
                                {{ live.red_team_points }}
                            </div>
                        </div> 
                        <Riders :riders="live.red_riders" />
                    </div> 
                    <div class="tw-w-1/2 tw-pl-2">
                        <div class="tw-bg-blue-600 tw-mb-4 tw-px-2 tw-rounded-lg tw-text-white tw-h-12 tw-flex tw-items-center tw-text-3xl">
                            <img class="tw--mt-10 tw-h-20 tw-mr-4" :src="live.blue_team.logo_url" alt="">
                            <div class="tw-flex-grow">
                                {{ live.blue_team.name }}
                            </div>
                            <div class="tw-bg-white tw-leading-none tw-py-1 tw-rounded-lg tw-text-black tw-text-center tw-w-24">
                                {{ live.blue_team_points }}
                            </div>
                        </div> 
                        <Riders :riders="live.blue_riders" />
                    </div> 
                    <div class="tw-w-1/2 tw-pr-2">
                        <div class="tw-bg-gray-400 tw-mb-4 tw-px-2 tw-rounded-lg tw-h-12 tw-flex tw-items-center tw-text-3xl">
                            <img class="tw--mt-10 tw-h-20 tw-mr-4" :src="live.white_team.logo_url" alt="">
                            <div class="tw-flex-grow">
                                {{ live.white_team.name }}
                            </div>
                            <div class="tw-bg-white tw-leading-none tw-py-1 tw-rounded-lg tw-text-black tw-text-center tw-w-24">
                                {{ live.white_team_points }}
                            </div>
                        </div> 
                        <Riders :riders="live.white_riders" />
                    </div> 
                    <div class="tw-w-1/2 tw-pl-2">
                        <div class="tw-bg-yellow-500 tw-mb-4 tw-px-2 tw-rounded-lg tw-text-yellow-900 tw-h-12 tw-flex tw-items-center tw-text-3xl">
                            <img class="tw--mt-10 tw-h-20 tw-mr-4" :src="live.yellow_team.logo_url" alt="">
                            <div class="tw-flex-grow">
                                {{ live.yellow_team.name }}
                            </div>
                            <div class="tw-bg-white tw-leading-none tw-py-1 tw-rounded-lg tw-text-black tw-text-center tw-w-24">
                                {{ live.yellow_team_points }}
                            </div>
                        </div> 
                        <Riders :riders="live.yellow_riders" />
                    </div> 
                </div>

                <div class="tw-h-40">
                    <div v-if="lastHeat" class="tw-flex tw-flex-col">
                        <div class="tw-pl-32 tw-ml-8 tw-mr-4 tw-flex tw-items-center">
                            <div class="tw-flex-grow">
                                Dernière manche <small class="tw-opacity-25">Last Heat</small>
                            </div>
                            <div class="tw-text-2xl tw-flex tw-items-center">
                                <div class="tw-flex tw-items-center tw-mr-4" v-if="lastHeat.riders.filter(r => r.pivot.points == 'D').length > 0">
                                    <div class="tw-h-10 tw-w-10 tw-rounded tw-mr-2 tw-bg-red-600 tw-text-white tw-font-bold tw-flex tw-items-center tw-justify-center tw-leading-none">
                                        D
                                    </div>
                                    <div class="tw-text-red-600">
                                        Disqualification
                                    </div>
                                </div>

                                <div class="tw-flex tw-items-center tw-mr-4" v-if="lastHeat.riders.filter(r => r.pivot.points == 'F').length > 0">
                                    <div class="tw-h-10 tw-w-10 tw-rounded tw-mr-2 tw-bg-red-600 tw-text-white tw-font-bold tw-flex tw-items-center tw-justify-center tw-leading-none">
                                        F
                                    </div>
                                    <div class="tw-text-red-600">
                                        Chute
                                    </div>
                                </div>

                                <div class="tw-flex tw-items-center tw-mr-4" v-if="lastHeat.riders.filter(r => r.pivot.points == 'R').length > 0">
                                    <div class="tw-h-10 tw-w-10 tw-rounded tw-mr-2 tw-bg-red-600 tw-text-white tw-font-bold tw-flex tw-items-center tw-justify-center tw-leading-none">
                                        R
                                    </div>
                                    <div class="tw-text-red-600">
                                        Retrait
                                    </div>
                                </div>

                                <div class="tw-flex tw-items-center tw-mr-4" v-if="lastHeat.riders.filter(r => r.pivot.points == 'M').length > 0">
                                    <div class="tw-h-10 tw-w-10 tw-rounded tw-mr-2 tw-bg-red-600 tw-text-white tw-font-bold tw-flex tw-items-center tw-justify-center tw-leading-none">
                                        M
                                    </div>
                                    <div class="tw-text-red-600">
                                        2 Minutes
                                    </div>
                                </div>

                                <div class="tw-flex tw-items-center tw-mr-4" v-if="lastHeat.riders.filter(r => r.pivot.points == 'T').length > 0">
                                    <div class="tw-h-10 tw-w-10 tw-rounded tw-mr-2 tw-bg-red-600 tw-text-white tw-font-bold tw-flex tw-items-center tw-justify-center tw-leading-none">
                                        T
                                    </div>
                                    <div class="tw-text-red-600">
                                        Faux départ
                                    </div>
                                </div>

                                <div class="tw-flex tw-items-center tw-mr-4" v-if="lastHeat.riders.filter(r => r.pivot.points == 'N').length > 0">
                                    <div class="tw-h-10 tw-w-10 tw-rounded tw-mr-2 tw-bg-red-600 tw-text-white tw-font-bold tw-flex tw-items-center tw-justify-center tw-leading-none">
                                        N
                                    </div>
                                    <div class="tw-text-red-600">
                                        Non Partant
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tw-bg-white tw-shadow tw-p-4 tw-flex tw-items-center tw-h-24">
                            <div class="tw-h-32 tw-w-24 tw-mr-4 tw-text-white tw-font-bold tw-rounded-lg tw-flex tw-items-center tw-justify-center tw-text-5xl tw-leading-none"
                            :class="isLive && live.is_promotion_cup ? 'tw-bg-green-800' : 'tw-bg-gray-700'">
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
                        <div class="tw-pl-32 tw-ml-8 tw-flex">
                            <div class="tw-flex-grow">
                                Manche suivante <small class="tw-opacity-25">Next Heat</small> 
                            </div>
                        </div>
                        <div class="tw-bg-white tw-shadow tw-p-4 tw-flex tw-items-center tw-h-24">
                            <div class="tw-h-32 tw-w-24 tw-mr-4 tw-text-white tw-font-bold tw-rounded-lg tw-flex tw-items-center tw-justify-center tw-text-5xl tw-leading-none"
                            :class="isLive && live.is_promotion_cup ? 'tw-bg-green-800' : 'tw-bg-gray-700'">
                                M{{ nextHeat.number }}
                            </div>

                            <div class="tw-flex tw-items-center tw-flex-grow" v-if="nextHeat.riders.length == 4">
                               <div class="tw-flex tw-justify-stretch tw-rounded-lg tw-shadow tw-mr-2" v-for="r of nextHeat.riders" v-if="r.pivot.gate">
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
                            <div v-else class="tw-text-gray-500">
                                La composition de cette manche n'est pas encore connue
                            </div>

                        </div>
                    </div>
                    <div v-else-if="showClassificationResults && live.is_lns">
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

                <div class="tw-h-40 tw-mt-6" v-if="live.is_lns">
                    <div v-if="heatAfter" class="tw-flex tw-flex-col">
                        <div class="tw-bg-white tw-shadow tw-p-4 tw-flex tw-items-center tw-h-24">
                            <div class="tw-h-32 tw-w-24 tw-mr-4 tw-bg-gray-700 tw-text-white tw-font-bold tw-rounded-lg tw-flex tw-items-center tw-justify-center tw-text-5xl tw-leading-none">
                                M{{ heatAfter.number }}
                            </div>

                            <div class="tw-flex tw-items-center tw-flex-grow" v-if="heatAfter.riders.length == 4">
                               <div class="tw-flex tw-justify-stretch tw-rounded-lg tw-shadow tw-mr-2" v-for="r of heatAfter.riders" v-if="r.pivot.gate">
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
                            <div v-else class="tw-text-gray-500">
                                La composition de cette manche n'est pas encore connue
                            </div>

                        </div>
                    </div>
                </div>

                

            </div>
            <div v-else-if="next_match" class="tw-flex tw-flex-col">
                <div class="tw-pt-8 tw-pb-8">
                    <LogoLns />
                </div>
                <div class="tw-py-4 tw-text-center tw-text-gray-800">
                    PROCHAIN MATCH
                </div>
                <div class="tw-flex tw-mx-16 tw-h-32 tw-rounded-lg tw-shadow-lg" v-if="next_match.is_lns">
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
                <div class="tw-flex tw-items-center tw-mx-16 tw-h-32 tw-rounded-lg tw-shadow-lg bg-promotion-cup" v-else-if="next_match.is_promotion_cup">
                    <div class="">
                        <LogoPromotionCup class="" />
                    </div>
                    <div class="tw-font-bold tw-flex-grow tw-uppercase tw-text-white tw-leading-tight tw-text-5xl tw-px-8">
                        SPEEDWAY<br>PROMOTION CUP
                    </div>
                    <div class="tw-flex tw-flex-wrap tw-w-1/2">
                        <div class="tw-w-1/2 tw-p-1 ">
                            <div class="tw-bg-red-700 tw-text-white tw-flex tw-items-center tw-uppercase tw-py-2 tw-px-2 tw-rounded-lg tw-text-3xl">
                                <div class="tw-mr-2">
                                    <img class="tw-object-contain tw-w-12 tw-h-12" :src="next_match.red_team.logo_url" alt="">
                                </div>
                                <div>
                                    {{ next_match.red_team.name }}
                                </div>
                            </div>
                        </div>
                        <div class="tw-w-1/2 tw-p-1 ">
                            <div class="tw-bg-blue-600 tw-text-white tw-flex tw-items-center tw-uppercase tw-py-2 tw-px-2 tw-rounded-lg tw-text-3xl">
                                <div class="tw-mr-2">
                                    <img class="tw-object-contain tw-w-12 tw-h-12" :src="next_match.blue_team.logo_url" alt="">
                                </div>
                                <div>
                                    {{ next_match.blue_team.name }}
                                </div>
                            </div>
                        </div>
                        <div class="tw-w-1/2 tw-p-1 ">
                            <div class="tw-bg-gray-400 tw-text-gray-900 tw-text-white tw-flex tw-items-center tw-uppercase tw-py-2 tw-px-2 tw-rounded-lg tw-text-3xl">
                                <div class="tw-mr-2">
                                    <img class="tw-object-contain tw-w-12 tw-h-12" :src="next_match.white_team.logo_url" alt="">
                                </div>
                                <div>
                                    {{ next_match.white_team.name }}
                                </div>
                            </div>
                        </div>
                        <div class="tw-w-1/2 tw-p-1 ">
                            <div class="tw-bg-yellow-500 tw-text-yellow-900 tw-flex tw-items-center tw-uppercase tw-py-2 tw-px-2 tw-rounded-lg tw-text-3xl">
                                <div class="tw-mr-2">
                                    <img class="tw-object-contain tw-w-12 tw-h-12" :src="next_match.yellow_team.logo_url" alt="">
                                </div>
                                <div>
                                    {{ next_match.yellow_team.name }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="isNextMatchToday" class="tw-mt-4 tw-flex-col tw-items-center">
                    <div class="tw-flex tw-justify-center">
                        
                        <div class="tw-w-32 tw-text-center tw-flex tw-flex-col tw-items-center">
                            <div class="tw-font-bold" style="font-size: 3rem;">{{ countdown_h }}</div>
                            <div class="tw-text-2xl">heures</div>
                        </div>
                        <div class="tw-w-32 tw-text-center tw-flex tw-flex-col tw-items-center">
                            <div class="tw-font-bold" style="font-size: 3rem;">{{ countdown_m }}</div>
                            <div class="tw-text-2xl">minutes</div>
                        </div>
                        <div class="tw-w-32 tw-text-center tw-flex tw-flex-col tw-items-center">
                            <div class="tw-font-bold" style="font-size: 3rem;">{{ countdown_s }}</div>
                            <div class="tw-text-2xl">secondes</div>
                        </div>
                    </div>
                </div>
                <div class="tw-mt-8 tw-flex tw-flex-col tw-items-center">
                    <div class="tw-w-1/2 tw-flex tw-flex-col tw-justify-center">
                        <div v-for="row of classification" class="tw-text-white tw-p-2 tw-mb-2 tw-rounded-full tw-shadow tw-flex tw-items-center tw-leading-none"
                        :style="{background: row.team.color}">
                            <div class="tw-w-16 tw-h-16 tw-text-gray-700 tw-bg-white tw-rounded-full tw-flex tw-items-center tw-justify-center">
                                {{ row.place }}
                            </div>
                            <div class="tw-flex tw-items-center tw-justify-center tw-px-4 tw-w-24">
                                <img class="tw-h-16" :src="row.team.logo_url" alt="" />
                            </div>
                            <div class="tw-uppercase tw-flex-grow">
                                {{ row.team.name }}
                            </div>
                            <div class="tw-h-16 tw-w-40 tw-px-8 tw-text-gray-700 tw-bg-white tw-rounded-full tw-flex tw-items-center tw-justify-center">
                                <div>
                                    {{ row.pts }} <span class="tw-text-gray-400 tw-text-2xl">{{ row.pts > 1 ? "pts" : "pt" }}</span>
                                </div>
                            </div>
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
import LogoPromotionCup from "../components/LogoPromotionCup";
import Riders from "../components/Riders";

    export default {
        props: ['slide'],
        components: {
            LogoLns, Riders, LogoPromotionCup
        },
        data: function () {
            return {
              live: null,
              isLive: false,
              lastHeat: null,
              nextHeat: null,
              heatAfter: null,
              showClassificationResults: false,

              next_match: null,
              now: Math.trunc((new Date()).getTime() / 1000),
              isNextMatchToday: false,
              countdown_h: 0,
              countdown_m: 0,
              countdown_s: 0,
              classification: null,
              
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
                        fetch(this.slide.data.api_url + "matches?scope=upcoming").then(async resp => {
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
                            this.isLive = false;
                            
                            fetch(this.slide.data.api_url + `divisions/${this.next_match.division.slug}/classification`).then(async resp => {
                                this.classification = await resp.json();
                            });
                        });
                    } else {
                        this.isLive = true;

                        let riders = {};

                        let isLns = json.is_lns;

                        if (isLns) {
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
                        } else {
                            for (let r of json.red_riders) {
                                r.heats = {};
                                r.total = 0;
                                riders[r.id] = r;
                            }
                            for (let r of json.blue_riders) {
                                r.heats = {};
                                r.total = 0;
                                riders[r.id] = r;
                            }
                            for (let r of json.white_riders) {
                                r.heats = {};
                                r.total = 0;
                                riders[r.id] = r;
                            }
                            for (let r of json.yellow_riders) {
                                r.heats = {};
                                r.total = 0;
                                riders[r.id] = r;
                            }
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

                        this.nextHeat = null;
                        this.heatAfter = null;
                        json.heats.filter(h => h.number == lastHeatId + 1).map(h => this.nextHeat = h);
                        json.heats.filter(h => h.number == lastHeatId + 2).map(h => this.heatAfter = h);

                        let sortRidersTotal = (a, b) => {
                            if (a.total > b.total) {
                                return -1;
                            } else if (a.total < b.total) {
                                return 1;
                            }
                            return 0;
                        };

                        let sortRidersNumber = (a, b) => {
                            if (a.pivot.number > b.pivot.number) {
                                return 1;
                            } else if (a.pivot.number < b.pivot.number) {
                                return -1;
                            }
                            return 0;
                        };

                        if (isLns) {
                            json.home_riders.sort(sortRidersTotal);
                            json.visitors_riders.sort(sortRidersTotal);

                            for (let r of json.home_riders) {
                                r.topScorer = r.total >= json.home_riders[3].total && lastHeatId >= 6;
                            }

                            for (let r of json.visitors_riders) {
                                r.topScorer = r.total >= json.visitors_riders[3].total && lastHeatId >= 6;
                            }

                            json.home_riders.sort(sortRidersNumber);
                            json.visitors_riders.sort(sortRidersNumber);
                        } else {
                            json.red_riders.sort(sortRidersNumber);
                            json.blue_riders.sort(sortRidersNumber);
                            json.white_riders.sort(sortRidersNumber);
                            json.yellow_riders.sort(sortRidersNumber);
                        }

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
            this.updateIntervalHandle = setInterval(() =>  this.updateData(), 60 * 1000);
            
            this.$events.on('shared-pusher:lns.update', data => {
                this.updateData();
            });

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
            this.$events.off('shared-pusher:lns.update');
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

    .bg-promotion-cup {
        background: #037101;
    }
</style>
