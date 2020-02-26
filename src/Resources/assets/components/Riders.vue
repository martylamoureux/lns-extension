<template>
    <div>
        <div class="tw-h-12 tw-bg-white tw-rounded-lg tw-shadow tw-mb-6 tw-text-2xl tw-px-2 tw-flex tw-items-center" v-for="rider of riders" :key="rider.id">
            <div class="tw-flex-grow tw-leading-none">
                {{ rider.pivot.number }}. {{ rider.name }}
            </div>
            <div class="tw-h-16 tw-w-12 tw-ml-2 tw-px-2 tw-bg-orange-500 tw-text-white tw-font-bold tw-rounded-full tw-flex tw-items-center tw-justify-center tw-text-3xl tw-leading-none"
                v-if="rider.pivot.warning">
                W
            </div>
            <div class="tw-h-16 tw-w-12 tw-ml-2 tw-px-2 tw-bg-gray-400 tw-font-bold tw-rounded tw-flex tw-items-center tw-justify-center tw-text-4xl tw-leading-none"
                :class="{'tw-bg-gray-400 tw-text-gray-800': !heat.ct, 'tw-bg-gray-900  tw-text-white': heat.ct}"
                v-for="heat of rider.heats" :key="heat.id" v-if="heat.points">
                {{ heat.points }}
            </div>
            <div class="tw-h-16 tw-ml-2 tw-w-16 tw-text-white tw-font-bold tw-rounded tw-flex tw-items-center tw-justify-center tw-text-4xl tw-leading-none"
                :class="{'tw-bg-blue-500': rider.topScorer, 'tw-bg-gray-500': !rider.topScorer}">
                {{ rider.total }}
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["riders"],
}
</script>