<template>
<span>
    <v-navigation-drawer v-model="drawer" app >
        <v-list dense nav>

            <v-list-item link v-for="(item, ind) in list" v-bind:key="ind" :to="item.path">
                <v-list-item-icon>
                    <v-icon>{{item.icon}}</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                    <v-list-item-title>{{item.title}}</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

        </v-list>
    </v-navigation-drawer>

    <v-app-bar app dark color="green">
        <v-app-bar-nav-icon @click.stop="draw" />
        <v-toolbar-title>
            <slot></slot>
        </v-toolbar-title>
        <v-spacer />

        <v-row v-if="$store.getters.getIsAuth" class="justify-end mr-1">
            <v-col cols="1" class="mt-4">
                <v-icon class="">mdi-account</v-icon>
            </v-col>
            <v-col cols="2" class="mt-4">
                <p>{{$store.getters.getEmail}}</p>
            </v-col>
            <v-col cols="1" class="mt-3">
                <v-btn text @click="logOut()">
                    <v-icon>mdi-logout</v-icon>
                </v-btn>
            </v-col>
        </v-row>

    </v-app-bar>
</span>
</template>

<script>
export default {
    props: ['list'],
    data() {
        return {
            drawer: false,
        }
    },
    methods: {
        logOut() {
            this.$store.dispatch('logOut');
            this.$router.push('/');
        },
        draw() {
            this.drawer = !this.drawer;
        },
    },
}
</script>