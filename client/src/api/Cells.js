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

    async addCell(cell_data) {
        return await
            Api()
                .post("/api/cells", {...cell_data});
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