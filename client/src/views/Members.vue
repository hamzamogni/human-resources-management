<template>
  <span>
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="headline">Add a new member</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field 
                    v-model="editedItem.name"
                    outlined 
                    label="First Name*" 
                    required
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field 
                    v-model="editedItem.surname" 
                    outlined 
                    label="Surname*" 
                    required
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field 
                    v-model="editedItem.email" 
                    outlined 
                    label="Email*" 
                    required
                ></v-text-field>
              </v-col>
              
              <v-col cols="12" sm="12">
                <v-autocomplete
                  v-model="assignedCell"
                  :items="cells"
                  color="white"
                  item-text="name"
                  item-value="id"
                  label="Choose Cell"
                  outlined
                  clearable
                ></v-autocomplete>
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
    <v-container>
      <v-row justify="center">
        <v-col cols="11">
          <v-data-table
            :headers="members_headers"
            :items="members"
            :items-per-page="5"
            :search="search"
            class="elevation-1"
          >
            <template v-slot:top>
              <v-card-title>
                Members
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
              <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
              <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
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
import { mapGetters } from "vuex";

export default {
  name: "Cells",

  data() {
    return {
      search: "",
      dialog: false,
      form_name: "",

      assignedCell: null,

      editedIndex: -1,
      editedItem: {
        name: "",
        surname: "",
        email: "",
      },
      defaultItem: {
        name: "",
        surname: "",
        email: "",
      },
    };
  },

  computed: {
    ...mapGetters(["members", "members_headers", "cells"])
  },

  methods: {

    editItem(item) {
      this.editedIndex = this.members.indexOf(item);
      this.editedItem = Object.assign({}, item);
      // this.assignedCell = item.cell.name;
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.cells.indexOf(item);
      if(confirm("Are you sure you want to delete this item?")) {
        this.$store.dispatch("DELETE_USER", {
          user_id: item.id
        })
      }
        
    },

    close() {
      this.dialog = false;
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 300);
    },

    save() {
      if (this.editedIndex > -1) {
        this.$store.dispatch("EDIT_USER", {
            id: this.editedItem.id,
            name: this.editedItem.name,
            surname: this.editedItem.surname,
            email: this.editedItem.email,
            cell_id: this.assignedCell
        })
      } else {
        this.$store.dispatch("ADD_USER", {
            name: this.editedItem.name,
            surname: this.editedItem.surname,
            email: this.editedItem.email,
            cell_id: this.assignedCell
        });
      }
      this.close();
    }
  },

};
</script>

<style scoped>
</style>