<template>
  <v-card outlined class="ma-5">
    <v-card-title>
      <div class="headline">Meetings Management</div>
      <v-spacer></v-spacer>
      <v-dialog v-model="is_adding_meeting" max-width="600px">
        <template v-slot:activator="{ on }">
          <v-btn color="indigo" dark v-on="on">Add Meeting</v-btn>
        </template>
        <v-card>
          <v-card-title>
            <span class="headline">{{ formTitle }}</span>
          </v-card-title>

          <v-card-text>
            <v-container>
              <v-row justify="space-around">
                <v-col cols="12">
                  <v-autocomplete
                    v-if="editedIndex <= -1"
                    v-model="editedItem.cell_id"
                    :items="cells"
                    color="white"
                    item-text="name"
                    item-value="id"
                    label="Choose the Cell"
                    outlined
                    clearable
                  ></v-autocomplete>
                </v-col>
                <v-col cols="12">
                  <v-date-picker 
                    v-model="editedItem.meeting_date" 
                    :min="new Date().toISOString().substr(0, 10)"
                    landscape 
                    full-width
                  ></v-date-picker>
                </v-col>
                <v-col cols="12">
                  <v-time-picker
                    v-model="editedItem.meeting_time"
                    format="24hr"
                    landscape
                    full-width
                  ></v-time-picker>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
            <v-btn color="blue darken-1" text @click="save">Save</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-card-title>
    <v-data-table
      :headers="meetings_headers"
      :items="meetings"
      :items-per-page="5"
      class="elevation-1"
    >
      <template v-slot:item.action="{ item }">
        <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
        <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
      </template>
    </v-data-table>
  </v-card>
</template>
<script>
import { mapGetters } from "vuex";
export default {
  data: () => ({
    is_adding_meeting: false,
    editedIndex: -1,
    editedItem: {
      cell_id: "",
      meeting_date: new Date().toISOString().substr(0, 10),
      meeting_time: null
    },
    defaultItem: {
      cell_id: "",
      meeting_date: new Date().toISOString().substr(0, 10),
      meeting_time: null
    }
  }),

  computed: {
    ...mapGetters(["meetings", "meetings_headers", "cells"]),

    formTitle() {
      return this.editedIndex === -1 ? "New Item" : "Edit Item";
    }
  },

  watch: {
    is_adding_meeting(val) {
      val || this.close();
    }
  },

  methods: {
    editItem(item) {
      this.editedIndex = this.meetings.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.is_adding_meeting = true;
    },
    deleteItem(item) {
      const index = this.meetings.indexOf(item);
      confirm("Are you sure you want to delete this item?") &&
        this.$store.dispatch("DELETE_MEETING", {
          id: item.id
        });
    },

    close() {
      this.is_adding_meeting = false;
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 300);
    },

    save() {
      if (this.editedIndex > -1) {
        this.$store
          .dispatch("EDIT_MEETING", this.editedItem)
          .then(() =>
            alert(
              "Meeting update succesfulyy, mails were sent to notify concerned members"
            )
          );
      } else {
        this.$store
          .dispatch("ADD_MEETING", this.editedItem)
          .then(() =>
            alert(
              "Meeting addded successfully, mails were sent to notify concerned members"
            )
          );
      }
      this.close();
    }
  }
};
</script>