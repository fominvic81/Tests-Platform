import axios from 'axios';
import React, { useEffect } from 'react';
import { createRoot } from 'react-dom/client';
import { createBrowserRouter, RouterProvider, useLoaderData, useParams } from 'react-router-dom';
import { testEditorId } from '..';
import { Question, Test } from '../../api'; 

const Editor: React.FC = () => {

    const { testId } = useParams();
    const data = useLoaderData();

    console.log(data);

    return <div>
        { testId }
    </div>;
}

const router = createBrowserRouter([
    {
        path: '/test/:testId/edit',
        element: <Editor></Editor>,
        loader: async ({ params }) => {
            return (await axios(`/api/test/${params.testId}`)).data as Test;
        }
    }
])

const root = createRoot(document.getElementById(testEditorId)!);

root.render(
    <React.StrictMode>
        <RouterProvider router={router}></RouterProvider>
    </React.StrictMode>
);
