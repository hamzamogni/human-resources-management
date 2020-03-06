import Members from "../../api/Members";

const state = {
    members: [],

    members_headers: [
        {
            text: 'ID',
            align: 'left',
            value: 'id',
        },
        {text: "Name", value:"name"},
        {text: "Surname", value:'surname'},
        {text: "email", value:"email"},
        {text: "project", value:"project.name"},
        {text: "cell", value: "cell.name"},
        {text: "birthday", value:"birthday"},
        {text: "Actions", value: "action", sortable: "false"},
    ]

};

const getters = {
    members: state => (state.members),
    members_headers: state => (state.members_headers),
};

const mutations = {
    GET_MEMBERS(state, members) {
        state.members = members;
    },

    ADD_USER(state, member) {
        state.members.push(member);
    },

    DELETE_USER(state, member) {
        // state.members.splice()
    }
};

const actions = {
    GET_MEMBERS({commit}) {
        Members.getMembers().then(
            resp => {
                commit("GET_MEMBERS", resp.data);
            }
        )
    },

    ADD_USER({commit}, data) {
        Members.addMember(data).then(
            resp => commit("ADD_USER", resp.data)
        )
    },

    EDIT_USER({commit, dispatch}, data) {
        Members.editUser(data).then(
            resp => dispatch("GET_MEMBERS")
        )
    },

    DELETE_USER({commit, dispatch}, data) {
        Members.deleteUser(data).then(
            resp => dispatch("GET_MEMBERS")
        )
    }
};

export default {state, getters, mutations, actions}