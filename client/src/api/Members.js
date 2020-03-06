import Api from "./Api";

export default {
    async getMembers() {
        return await
            Api()
                .get("/api/users")
    },

    async addMember(data) {
        return await
            Api()
                .post("/api/users", {
                    "name": data.name,
                    "surname": data.surname,
                    "email": data.email,
                    "cell_id": data.cell_id
                })
    },

    async editUser(data) {
        return await
            Api()
                .patch("/api/users/" + data.id, {
                    ...data
                })
    },

    async deleteUser(data) {
        return await
            Api()
                .delete("/api/users/" + data.user_id)
    },
}