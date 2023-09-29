import axios from 'axios'
import { Grade, Subject, TestOptions } from './types'

export const getTestOptions = async () => {
    const options = (await axios('/api/test-options')).data as TestOptions;
    return options;
}