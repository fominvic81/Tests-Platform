import axios from 'axios';
import { Session } from './types';


export const getSession = async (id: string | number) => {
    const session = (await axios(`/api/session/${id}`)).data as Session;
    return session;
}