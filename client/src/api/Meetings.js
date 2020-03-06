import Api from "./Api";

export default {
    async getMeetings() {
        return await 
            Api()
                .get("/api/meetings")
    },

    async addMeeting(data) {
        return await 
            Api()
                .post("/api/meetings", {
                    'meeting_date': data.meeting_date,
                    'meeting_time': data.meeting_time,
                    'cell_id': data.cell_id
                })
    },

    async editMeeting(data) {
        return await
            Api()
                .patch("/api/meetings/" + data.id, data)
    },

    async deleteMeeting(data) {
        return await    
            Api()
                .delete("/api/meetings/" + data.id)
    }
}