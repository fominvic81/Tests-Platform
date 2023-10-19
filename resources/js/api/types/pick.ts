

export type PickCond<T, K extends keyof T | ''> = Omit<T, keyof Omit<T, K>>;
