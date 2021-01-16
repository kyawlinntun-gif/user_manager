<template>
    <div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-if="results.current_page > 2" class="page-item" @click.prevent="$emit('getPage', 1)">
                    <a class="page-link" href="#"><i class="fas fa-angle-double-left"></i></a>
                </li>
                <li v-if="results.current_page > 1" class="page-item" @click.prevent="$emit('getPage', results.current_page - 1)">
                    <a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a>
                </li>

                <li class="page-item" v-if="results.current_page > 5">
                    <a href="#" class="page-link">...</a>
                </li>

                <li class="page-item" v-for="num in results.last_page" v-if="num > results.current_page - 5 && num < results.current_page + 5" :key="num" :class="{'active' : num === results.current_page}" @click.prevent="$emit('getPage', num)">
                    <a class="page-link" href="#">{{ num }}</a>
                </li>

                <li class="page-item" v-if="results.current_page < results.last_page - 4">
                    <a href="#" class="page-link">...</a>
                </li>

                <li v-if="results.current_page < results.last_page" class="page-item" @click.prevent="$emit('getPage', results.current_page + 1)">
                    <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                </li>
                <li v-if="results.current_page < results.last_page - 1" class="page-item" @click.prevent="$emit('getPage', results.last_page)">
                    <a class="page-link" href="#"><i class="fas fa-angle-double-right"></i></a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
    export default {
        name: 'Paginator',
        props: [
            'results'
        ]
    }

</script>

<style>

</style>
