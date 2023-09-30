import axios from 'axios'


export const deleteQuestion = async (id: number | string) => {
    const response = await axios.delete(`/api/question/${id}`).catch((reason) => {
        console.error(reason);
    });

    return !!response;
}