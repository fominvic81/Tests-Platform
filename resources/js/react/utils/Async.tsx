import React, { createContext, useContext, useEffect, useState } from 'react';

interface Props extends React.PropsWithChildren {
    loader: () => Promise<any>;
    loadingComponent?: React.ReactNode;
    errorComponent?: React.ReactNode;
}

const AsyncContext = createContext<any>(null);

export const Async: React.FC<Props> = ({ children, loader, loadingComponent, errorComponent }) => {
    const [isLoading, setIsLoading] = useState(true);
    const [error, setError] = useState();
    const [value, setValue] = useState<Awaited<ReturnType<typeof loader>>>();

    useEffect(() => {
        loader().then(setValue).catch(setError).finally(() => setIsLoading(false));
    }, []);

    return <>
        { isLoading && loadingComponent }
        { error && errorComponent }
        { value && <AsyncContext.Provider value={ value }>{ children }</AsyncContext.Provider> }
    </>
}

export const useAsync = <T = any>() => {
    const context = useContext(AsyncContext);

    return context as T;
}