import Cells from "../../api/Cells";

const state = {
    cells: [],

    headers: [
        {
            text: 'Name',
            align: 'left',
            value: 'name',
        },
        { text: "Chief", value: "chief.full_name" },
        { text: 'Members', value: 'count_users' },
        { text: "Description", value: 'description' },
        { text: "Actions", value: "action", sortable: "false" },
    ],

    dialog_add_cell: false,
};

const getters = {
    cells: state => (state.cells),
    headers: state => (state.headers),

    dialog_add_cell: state => (state.dialog_add_cell),
};

const actions = {
    GET_CELLS({ commit }) {
        Cells.getCells().then(
            resp => {
                commit("GET_CELLS", resp.data);
            }
        )
    },

    ADD_CELL({ commit, dispatch }, data) {
        Cells.addCell(data)
            .then( (resp) => {
                console.log(resp)
                dispatch("GET_CELLS")
            })
    },

    DELETE_CELL({ commit, dispatch }, data) {
        Cells.deleteCell(data)
            .then( () => dispatch("GET_CELLS") )
    },

    UPDATE_CHIEF({ commit }, data) {
        Cells.updateChief(data).then(
            resp => commit("UPDATE_CELL", resp.data)
        )
    },

    DELETE_CHIEF({ commit }, data) {
        Cells.deleteChief(data).then(
            resp => commit("UPDATE_CELL", resp.data)
        )
    }
};

const mutations = {
    GET_CELLS(state, cells) {
        state.cells = cells;
    },

    UPDATE_CELL(state, updt_cell) {
        let index = state.cells.findIndex(x => x.id === updt_cell.id);
        if (index !== -1)
            Object.assign(state.cells[index], updt_cell)
        else {
            for (let cell in state.cells) {
                for (let idx_children in state.cells[cell].children) {
                    console.log(state.cells[cell].children[idx_children].id)
                    if (state.cells[cell].children[idx_children].id == updt_cell.id) {
                        Object.assign(state.cells[cell].children[idx_children], updt_cell);               
                        return;
                    }
                        
                }
            }
        }
    },
};

export default {
    state,
    getters,
    actions,
    mutations,
}