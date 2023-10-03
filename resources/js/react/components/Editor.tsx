import React, { useState } from 'react';
import { EditorProvider, useCurrentEditor, ChainedCommands } from '@tiptap/react'
import ListItem from '@tiptap/extension-list-item';
import { Color } from '@tiptap/extension-color';
import TextStyle from '@tiptap/extension-text-style';
import StarterKit from '@tiptap/starter-kit';
import Placeholder from '@tiptap/extension-placeholder';
import Subscript from '@tiptap/extension-subscript';
import Superscript from '@tiptap/extension-superscript';
import Underline from '@tiptap/extension-underline';

interface MenuButtonProps extends React.PropsWithChildren {
    action: (chain: ChainedCommands) => ChainedCommands;
    name?: string;
}

const MenuButton: React.FC<MenuButtonProps> = ({ action, children, name }) => {
    const { editor } = useCurrentEditor();

    if (!editor) return;

    return <button type='button' 
        onClick={() => action(editor.chain().focus()).run()}
        disabled={!action(editor.can().chain().focus()).run()}
        className={`px-2 mx-1 rounded ${name && editor.isActive(name) ? 'font-bold bg-gray-200' : 'bg-gray-50'}`}>{ children }</button>
}

const MenuBar: React.FC = () => {
    const { editor } = useCurrentEditor()

    if (!editor) return;

    return (
        <div className='bg-gray-50 border-2 border-b-0 p-2 '>
            <MenuButton action={(chain) => chain.toggleBold()} name='bold'>B</MenuButton>
            <MenuButton action={(chain) => chain.toggleItalic()} name='italic'>I</MenuButton>
            <MenuButton action={(chain) => chain.toggleStrike()} name='strike'>S</MenuButton>
            <MenuButton action={(chain) => chain.toggleUnderline()} name='underline'>U</MenuButton>
            <MenuButton action={(chain) => chain.toggleBulletList()} name='bulletList'>-</MenuButton>
            <MenuButton action={(chain) => chain.toggleOrderedList()} name='orderedList'>1</MenuButton>
            <MenuButton action={(chain) => chain.toggleCodeBlock()} name='codeBlock'>C</MenuButton>
            <MenuButton action={(chain) => chain.toggleBlockquote()} name='blockquote'>q</MenuButton>
            <MenuButton
                action={(chain) => {
                    chain.unsetSubscript();
                    return chain.toggleSuperscript();
                }}
                name='superscript'
            >2</MenuButton>
            <MenuButton
                action={(chain) => {
                    chain.unsetSuperscript();
                    return chain.toggleSubscript();
                }}
                name='subscript'
            >s</MenuButton>
            <MenuButton action={(chain) => chain.setHorizontalRule()}>H</MenuButton>
            <MenuButton action={(chain) => chain.setHardBreak()}>N</MenuButton>
            <MenuButton action={(chain) => chain.undo()} name='undo'>U</MenuButton>
            <MenuButton action={(chain) => chain.redo()} name='redo'>R</MenuButton>
            <MenuButton action={(chain) => editor.isActive('textStyle', { color: '#958DF1' }) ? chain.unsetColor() : chain.setColor('#958DF1')}>P</MenuButton>
        </div>
    )
}

const extensions = [
    Color.configure({ types: [TextStyle.name, ListItem.name] }),
    // @ts-ignore
    TextStyle.configure({ types: [ListItem.name] }),
    StarterKit.configure({
        bulletList: {
            keepMarks: true,
            keepAttributes: false, // TODO : Making this as `false` becase marks are not preserved when I try to preserve attrs, awaiting a bit of help
        },
        orderedList: {
            keepMarks: true,
            keepAttributes: false, // TODO : Making this as `false` becase marks are not preserved when I try to preserve attrs, awaiting a bit of help
        },
    }),
    Placeholder.configure({
        placeholder: 'Placeholder',
    }),
    Underline.configure(),
    Superscript.configure(),
    Subscript.configure(),
];

interface Props {
    name: string;
    id: string;
}

export const Editor: React.FC<Props> = ({ name, id }) => {

    const [value, setValue] = useState('<div>Hello world!</div>');

    return <div className='break-words'>
        <input type='hidden' name={ name } id={ id } value={ value }></input>
        <EditorProvider
            editorProps={{
                attributes: {
                    class: 'bg-gray-50 border-2 p-1',
                },
            }}
            onUpdate={({ editor }) => setValue(editor.getHTML())}
            slotBefore={<MenuBar></MenuBar>}
            extensions={extensions}
            content={value}
        > </EditorProvider>
    </div>;
}
