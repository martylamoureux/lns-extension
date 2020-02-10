<template>
    <div>
        <div class="tw-h-16 tw-bg-white tw-rounded-lg tw-shadow tw-mb-6 tw-text-3xl tw-px-2 tw-flex tw-items-center" v-for="rider of riders" :key="rider.id">
            <div class="tw-flex-grow">
                {{ rider.pivot.number }}. {{ rider.name }}
            </div>
            <div class="tw-h-20 tw-w-12 tw-ml-2 tw-px-2 tw-bg-orange-500 tw-text-white tw-font-bold tw-rounded-full tw-flex tw-items-center tw-justify-center tw-text-3xl tw-leading-none"
                v-if="rider.pivot.warning">
                W
            </div>
            <div class="tw-h-20 tw-w-12 tw-ml-2 tw-px-2 tw-bg-gray-400 tw-text-gray-800 tw-font-bold tw-rounded tw-flex tw-items-center tw-justify-center tw-text-5xl tw-leading-none"
                v-for="heat of rider.heats" :key="heat.id" v-if="heat.points">
                {{ heat.points }}
            </div>
            <div class="tw-h-20 tw-ml-2 tw-w-20 tw-bg-gray-500 tw-text-white tw-font-bold tw-rounded tw-flex tw-items-center tw-justify-center tw-text-5xl tw-leading-none">
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