<template>
    <v-app id="inspire">
        <v-navigation-drawer
                v-model="drawer"
                app
        >
            <v-list dense>
                <v-list-item link v-for="item in drawer_data" :key="item.text" :to="item.route">
                    <v-list-item-action>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>{{ item.text }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar
                app
                color="indigo"
                dark
        >
            <v-app-bar-nav-icon @click.stop="drawer = !drawer"/>
            <v-toolbar-title>Human Resources</v-toolbar-title>
        </v-app-bar>

        <v-content>
            <router-view/>
        </v-content>

            <v-footer
              color="indigo"
              app
            >
              <span class="white--text">&copy; 2019</span>
            </v-footer>

    </v-app>
</template>

<script>
    export default {
        props: {
            source: String,
        },
        data: () => ({
            drawer: null,

            drawer_data: [
                {icon: "mdi-home", text: "Home", route: "/"},
                {icon: "mdi-contact-mail", text: "Members", route: "/members"},
                {icon: "mdi-account-multiple", text: "Cells", route: "/cells"},
                {icon: "mdi-account-group", text: "Meetings", route: "/meetings"}
            ]
        }),

        beforeCreate() {
            this.$store.dispatch("GET_CELLS");
            this.$store.dispatch("GET_MEMBERS");
            this.$store.dispatch("GET_MEETINGS");
        }
    }
</script>
