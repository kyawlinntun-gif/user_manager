<template>
    <h5>
        Showing {{ results.from }} to {{ results.to }} of {{ results.total }} | Page {{ results.current_page }} of {{ results.last_page }}
    </h5>
</template>

<script>
export default {
    name: 'PaginatorDetail',
    props: [
        'results'
    ]
}
</script>

<style>

</style>