import Api from "./Api";

export default {
    async getMembers() {
        return await
            Api()
                .get("/api/users")
    },

    async addMember(member_data) {
        return await
            Api()
                .post("/api/users", {...member_data})
    }
}