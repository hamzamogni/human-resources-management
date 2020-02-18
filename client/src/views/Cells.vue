<template>
  <v-card>
    <v-card-title class="headline">
      Cells Management
      <v-spacer></v-spacer>
      <v-btn class="indigo" dark>Add a Cell</v-btn>
    </v-card-title>
    <v-divider></v-divider>
    <v-row class="pa-4" justify="space-between">
      <v-col cols="5">
        <v-treeview
          :active.sync="active"
          :items="cells"
          :open.sync="open"
          @update:active="defaultState"
          activatable
          color="warning"
          transition
        >
          <template v-slot:prepend="{ item, active }">
            <v-icon>mdi-account-group</v-icon>
          </template>
        </v-treeview>
      </v-col>

      <v-divider vertical></v-divider>

      <v-col class="d-flex">
        <v-scroll-y-transition mode="out-in">
          <div
            v-if="!selected"
            class="title grey--text text--lighten-1 font-weight-light"
            style="align-self: center;"
          >Select a Cell</div>
          <v-card v-else :key="selected.id" class="pt-6 mx-auto" flat max-width="500">
            <v-card-text class="text-center">
              <h3 class="title font-weight-bold black--text mb-2">{{ selected.name }}</h3>
              <div v-if="selected.hasChief">
                <v-avatar v-if="avatar" size="88">
                  <v-img :src="`https://avataaars.io/${avatar}`" class="mb-6"></v-img>
                </v-avatar>
                <h3>{{ selected.chief.full_name }}</h3>
                <div class="blue--text mb-2">{{ selected.chief.email }}</div>

                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-btn
                      @click="isAssigningChief = !isAssigningChief"
                      class="mx-2"
                      fab
                      dark
                      x-small
                      color="cyan"
                      v-on="on"
                    >
                      <v-icon dark>mdi-pencil</v-icon>
                    </v-btn>
                  </template>
                  <span>Change Chief</span>
                </v-tooltip>

                <v-tooltip bottom>
                  <template v-slot:activator="{ on }">
                    <v-btn
                      @click="isDeletingChief = true"
                      class="mx-2"
                      fab
                      dark
                      x-small
                      color="red"
                      v-on="on"
                    >
                      <v-icon dark>mdi-delete</v-icon>
                    </v-btn>
                  </template>
                  <span>Delete Chief</span>
                </v-tooltip>

                <v-scale-transition>
                  <v-card v-if="isDeletingChief" outlined class="mt-2">
                    <v-card-title>Are you Sure ?</v-card-title>
                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn @click="deleteChief" text color="red">Yes</v-btn>
                      <v-btn @click="isDeletingChief = false" text color="indigo">No</v-btn>
                    </v-card-actions>
                  </v-card>
                </v-scale-transition>
              </div>

              <v-btn
                v-else
                v-on="on"
                @click="isAssigningChief=!isAssigningChief"
                class="mt-2"
                dark
                small
                color="indigo"
              >Assign Chief</v-btn>

              <v-expand-transition>
                <v-card outlined class="mt-2" v-if="isAssigningChief">
                  <v-card-text class="pb-0">
                    <v-autocomplete
                      v-model="assignedChief"
                      :items="members"
                      color="white"
                      item-text="fullname"
                      item-value="id"
                      label="Choose a Chief"
                      outlined
                      clearable
                    ></v-autocomplete>
                  </v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn :disabled="!assignedChief" @click="updateChief" text color="indigo">Done</v-btn>
                  </v-card-actions>
                </v-card>
              </v-expand-transition>
            </v-card-text>
            <v-divider></v-divider>
            <h3 class="my-2">Description</h3>
            <div class="body-1">{{selected.description}}</div>
            <h3 class="my-2">Members</h3>

            <v-card outlined>
              <v-card-title>
                <v-text-field
                  v-model="members_table.search"
                  append-icon="mdi-magnify"
                  label="Search"
                  single-line
                  hide-details
                ></v-text-field>
              </v-card-title>
              <v-data-table
                :headers="members_table.headers"
                :search="members_table.search"
                :items="selected.users"
                :items-per-page="5"
                sort-by="name"
                disable-pagination
              >
                <template v-slot:item.action="{ item }">
                  <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
                </template>
              </v-data-table>
            </v-card>
          </v-card>
        </v-scroll-y-transition>
      </v-col>
    </v-row>
  </v-card>
</template>

<script>
import { mapGetters } from "vuex";
import Cells from "../api/Cells";
const avatars = [
  "?accessoriesType=Blank&avatarStyle=Circle&clotheColor=PastelGreen&clotheType=ShirtScoopNeck&eyeType=Wink&eyebrowType=UnibrowNatural&facialHairColor=Black&facialHairType=MoustacheMagnum&hairColor=Platinum&mouthType=Concerned&skinColor=Tanned&topType=Turban",
  "?accessoriesType=Sunglasses&avatarStyle=Circle&clotheColor=Gray02&clotheType=ShirtScoopNeck&eyeType=EyeRoll&eyebrowType=RaisedExcited&facialHairColor=Red&facialHairType=BeardMagestic&hairColor=Red&hatColor=White&mouthType=Twinkle&skinColor=DarkBrown&topType=LongHairBun",
  "?accessoriesType=Prescription02&avatarStyle=Circle&clotheColor=Black&clotheType=ShirtVNeck&eyeType=Surprised&eyebrowType=Angry&facialHairColor=Blonde&facialHairType=Blank&hairColor=Blonde&hatColor=PastelOrange&mouthType=Smile&skinColor=Black&topType=LongHairNotTooLong",
  "?accessoriesType=Round&avatarStyle=Circle&clotheColor=PastelOrange&clotheType=Overall&eyeType=Close&eyebrowType=AngryNatural&facialHairColor=Blonde&facialHairType=Blank&graphicType=Pizza&hairColor=Black&hatColor=PastelBlue&mouthType=Serious&skinColor=Light&topType=LongHairBigHair",
  "?accessoriesType=Kurt&avatarStyle=Circle&clotheColor=Gray01&clotheType=BlazerShirt&eyeType=Surprised&eyebrowType=Default&facialHairColor=Red&facialHairType=Blank&graphicType=Selena&hairColor=Red&hatColor=Blue02&mouthType=Twinkle&skinColor=Pale&topType=LongHairCurly"
];

export default {
  data: () => ({
    active: [],
    avatar: null,
    open: [],
    users: [],

    isDeletingChief: false,
    isAssigningChief: false,
    assignedChief: null,

    members_table: {
      headers: [
        { text: "Name", value: "name" },
        { text: "Actions", value: "action", sortable: false }
      ],
      search: ""
    }
  }),

  computed: {
    ...mapGetters(["cells", "members"]),
    items() {
      return [
        {
          name: "Users",
          children: this.users
        }
      ];
    },
    selected() {
      if (!this.active.length) return undefined;

      const id = this.active[0];
      if (!!this.cells.find(item => item.id === id))
        return this.cells.find(item => item.id === id);
      else {
        for (let cell in this.cells) {
          for (let idx_children in this.cells[cell].children) {
            if (this.cells[cell].children[idx_children].id === id)
              return this.cells[cell].children.find(item => item.id === id);
          }
        }
      }
    }
  },

  watch: {
    selected: "randomAvatar"
  },

  methods: {
    randomAvatar() {
      this.avatar = avatars[Math.floor(Math.random() * avatars.length)];
    },

    updateChief() {
      this.$store
        .dispatch("UPDATE_CHIEF", {
          cell_id: this.selected.id,
          chief_id: this.assignedChief
        })
        .then(() => {
          this.isAssigningChief = false;
        });
    },

    deleteChief() {
      this.$store.dispatch("DELETE_CHIEF", this.selected.id);
    },

    defaultState() {
      this.isAssigningChief = false;
      this.isDeletingChief = false;
    }
  },

  mounted: function() {
    this.$store.dispatch("GET_CELLS");
    this.$store.dispatch("GET_MEMBERS");
    this.randomAvatar();
  }
};
</script>