import React from 'react';
import { createRoot } from 'react-dom/client';
import { TestingShowId } from '../..';
import { Async, useAsync } from '../../utils';

type AsyncData = [];

const Component: React.FC = () => {
    const [] = useAsync() as AsyncData;

    return <>123dfs</>;
}

const root = createRoot(document.getElementById(TestingShowId)!);

root.render(
    <React.StrictMode>
        <Async loader={() => Promise.all([])}>
            <Component></Component>
        </Async>
    </React.StrictMode>
);