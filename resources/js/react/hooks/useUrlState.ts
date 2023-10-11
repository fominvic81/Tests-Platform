import { useEffect, useState } from 'react';

export const useUrlState = <T extends Record<string, NonNullable<unknown>>>(defaultValues: T) => {
    const url = new URL(location.href);

    const initialValues = Object.fromEntries(Object.entries(defaultValues).map(([key, value]) => {
        const current = url.searchParams.get(key);
        if (current) return [key, JSON.parse(current)];
        return [key, value];
    })) as T;

    const [state, setState] = useState(initialValues);

    useEffect(() => {
        const listener = (event: PopStateEvent) => {
            const params = new URLSearchParams(location.search);
            for (const key of Object.keys(initialValues)) {
                const value = params.get(key);
                const currentValue = value ? JSON.parse(value) : defaultValues[key];

                setState((current) => ({ ...current, [key]: currentValue }));
            }
        }

        window.addEventListener('popstate', listener);
        return () => window.removeEventListener('popstate', listener);
    }, []);

    return [state, (values: Partial<T>, replace: boolean = false) => {
        const newUrl = new URL(location.href);
        const params = newUrl.searchParams;
        let changed = false;

        for (const [key, value] of Object.entries(values)) {
            const stringified = JSON.stringify(value);
            if (stringified === JSON.stringify(state[key])) continue;
            changed = true;
    
            if (!value || stringified === JSON.stringify(defaultValues[key])) {
                params.delete(key);
            } else {
                params.set(key, JSON.stringify(value));
            }
            setState((current) => ({ ...current, [key]: value ?? defaultValues[key] }));
        }
        if (changed) {
            if (replace) {
                window.history.replaceState({}, '', newUrl.href);
            } else {
                window.history.pushState({}, '', newUrl.href);
            }
        }
    }] as const;
}