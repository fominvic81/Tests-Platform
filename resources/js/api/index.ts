

export * from './types';

export * from './question';
export * from './enumText';

export * from './getTest';
export * from './getTestOptions';
export * from './deleteQuestion';
export * from './getSession';

export * from './storagePath';

let lastId = 0;
export const getUniqueId = () => lastId++;