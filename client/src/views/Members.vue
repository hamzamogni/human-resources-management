<template>
    <span>
        <v-dialog v-model="dialog" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline">Add a new cell</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12">
                                <v-text-field
                                        v-model="editedItem.name"
                                        outlined
                                        label="Name*"
                                        required
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="12">
                                <v-label>Chef de Cellule</v-label>
                                <v-select
                                        outlined
                                        v-model="editedItem.chief.full_name"
                                        :items="['Bouaali', 'ElGuenni', 'Bazman', 'Zaryouh']"
                                        :label="editedItem.chief.full_name"
                                ></v-select>
                            </v-col>
                            <v-col cols="12">
                                <v-textarea
                                        v-model="editedItem.description"
                                        outlined
                                        name="description"
                                        label="Description"
                                ></v-textarea>
                            </v-col>
                        </v-row>
                    </v-container>
                    <small>*indicates required field</small>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="close">Close</v-btn>
                    <v-btn color="blue darken-1" text @click="save">Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-container

        >
            <v-row justify="center">
                <v-col cols="11">
                        <v-data-table
                                :headers="headers"
                                :items="cells"
                                :items-per-page="5"
                                :search="search"
                                class="elevation-1"
                        >
                            <template v-slot:top>
                              <v-card-title>
                                  Cells
                                  <v-spacer></v-spacer>
                                  <v-text-field
                                          v-model="search"
                                          append-icon="mdi-magnify"
                                          label="Search"
                                          single-line
                                          hide-details
                                  ></v-text-field>
                                </v-card-title>
                            </template>

                             <template v-slot:item.action="{ item }">
                              <v-icon
                                      small
                                      class="mr-2"
                                      @click="editItem(item)"
                              >
                                mdi-pencil
                              </v-icon>
                              <v-icon
                                      small
                                      @click="deleteItem(item)"
                              >
                                mdi-delete
                              </v-icon>
                            </template>
                        </v-data-table>
                </v-col>
            </v-row>
        </v-container>

        <v-btn
                @click="dialog = true"
                color="indigo"
                dark
                absolute
                bottom
                right
                fab
                style="bottom: 50px"
        >
            <v-icon>mdi-plus</v-icon>
        </v-btn>
    </span>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "Cells",

        data() {
            return {
                search: "",
                dialog: false,
                form_name: "",
                form_description: "",

                descriptionLimit: 60,
                entries: [],
                isLoading: false,
                model: null,
                search_chief: null,

                editedIndex: -1,
                editedItem: {
                    id: 50,
                    name: "",
                    chief: {
                        full_name: ""
                    },
                    description: "",
                    count_users: 0,
                },
                defaultItem: {
                    id: 1129,
                    name: "",
                    chief: {
                        full_name: ""
                    },
                    description: "",
                    count_users: 0,
                }
            }
        },

        computed: {
            ...mapGetters([
                'headers',
                'cells'
            ])
        },

        methods: {
            add_cell() {
                this.$store.dispatch("ADD_CELL", {
                    name: this.form_name,
                    description: this.form_description,
                })
            },

            editItem(item) {
                this.editedIndex = this.cells.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
            },

            deleteItem(item) {
                const index = this.cells.indexOf(item)
                confirm('Are you sure you want to delete this item?') && this.cells.splice(index, 1)
            },

            close() {
                this.dialog = false
                setTimeout(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                }, 300)
            },

            save() {
                if (this.editedIndex > -1) {
                    Object.assign(this.cells[this.editedIndex], this.editedItem)
                } else {
                    this.cells.push(this.editedItem)
                }
                this.close()
            },
        },

        mounted() {
            this.$store.dispatch("GET_CELLS");
        }
    }
</script>

<style scoped>

</style>