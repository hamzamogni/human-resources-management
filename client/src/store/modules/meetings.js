import Meetings from "../../api/Meetings";

const state = {
    meetings: [],
    meetings_header: [
        {text: "Cell", value: "cell.name"},
        {text: "Date", value: "meeting_date"},
        {text: "Time", value:"meeting_time"},
        {text: "Actions", value: "action", sortable: "false"},
    ]
}

const getters = {
    meetings: state => (state.meetings),
    meetings_headers: state => (state.meetings_header),
}

const mutations = {
    GET_MEETINGS(state, meetings) {
        state.meetings = meetings;
    },

    ADD_MEETING(state, meeting) {
        state.meetings.push(meeting)
    }
}

const actions = {
    GET_MEETINGS({commit}) {
        Meetings.getMeetings().then(
            resp => commit("GET_MEETINGS", resp.data)
        )
    },

    ADD_MEETING({commit}, data) {
        Meetings
            .addMeeting(data)
            .then(resp => {
                commit("ADD_MEETING", resp.data)
            })
    },

    EDIT_MEETING({commit, dispatch}, data) {
        Meetings
            .editMeeting(data)
            .then(() => dispatch("GET_MEETINGS"))
    },

    DELETE_MEETING({dispatch}, data) {
        Meetings
            .deleteMeeting(data)
            .then(() => dispatch("GET_MEETINGS"))
    }
}

export default {state, getters, mutations, actions}