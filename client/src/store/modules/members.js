import Members from "../../api/Members";

const state = {
    members: {},

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
};

export default {state, getters, mutations, actions}