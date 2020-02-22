import Api from "./Api";

export default {
    async getCells() {
        return await
            Api()
                .get("/api/cells");
    },

    async getCell(id) {
        return await
            Api()
                .get("/api/cells/" + id);
    },

    async addCell(data) {
        return await
            Api()
                .post("/api/cells", {
                    "name": data.cell_name,
                    "description": data.cell_description,
                    "isSubcell": data.isSubcell,
                    "parent_id": data.parent_id
                });
    },

    async deleteCell(data) {
        return await 
            Api()
                .delete("/api/cells/" + data.cell_id)
    },

    async updateChief(data) {
        return await
            Api()
                .post("/api/cells/" + data.cell_id + "/update_chief", {
                    "chief_id": data.chief_id,
                });
    },

    async deleteChief(id) {
        return await 
            Api()
                .post("/api/cells/" + id + "/delete_chief")
    }
}