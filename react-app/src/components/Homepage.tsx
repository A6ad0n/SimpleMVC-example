import React, { useState } from 'react';
import { Link } from 'react-router-dom';
import HomepageLayout from './Layouts/HomepageLayout';
import { formatDate } from '../utils/Date';
import { buildApiLink, truncateContent } from '../utils/String';
import type { Note } from '../@types/api/Note';
import { useFetchData } from '../hooks/UseFetchData';
import type { Response} from '../@types/api/Response';


const Homepage = () => {
  const [expandedContent, setExpandedContent] = useState<{ [key: number]: string }>({});
  const [loadingContent, setLoadingContent] = useState<number | null>(null);

  const { data: notes } = useFetchData<Note[]>('homepage/index');

  const fetchFullContent = async (noteId: number) => {
    if (expandedContent[noteId]) {
      setExpandedContent(prev => {
        const newState = { ...prev };
        delete newState[noteId];
        return newState;
      });
      return;
    }

    setLoadingContent(noteId);
    try {
      const url = buildApiLink(`ajax/getContent&articleId=${noteId}`)
      const response = await fetch(url, {
        headers: { 'Accept': 'application/json' }
      });
      
      if (response.ok) {
        const result: Response = await response.json();
        if (result.success) {
          console.log(result.data.preparedData);
          setExpandedContent(prev => ({
            ...prev,
            [noteId]: String(result.data.preparedData[0]) || 'No content available'
          }));
        }
      }
    } catch (err) {
      console.error('Error fetching note content:', err);
    } finally {
      setLoadingContent(null);
    }
  };

  const handleAjaxPost = async (noteId: number) => {
    setLoadingContent(noteId);
    try {
      const url = buildApiLink('ajax/getContent')
      const response = await fetch(url, {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: noteId })
      });
      
      if (response.ok) {
        const result: Response = await response.json();
        if (result.success) {
          console.log(result.data.preparedData)
          setExpandedContent(prev => ({
            ...prev,
            [noteId]: String(result.data.preparedData) || 'No content available'
          }));
        }
      }
    } catch (err) {
      console.error('Error in POST request:', err);
    } finally {
      setLoadingContent(null);
    }
  };

  return (
    <HomepageLayout>
        <div className="w-3/4">
            <ul className="list-none pl-0">
                {notes?.map((note) => (
                <li 
                    key={note.noteId} 
                    id={`note-${note.noteId}`}
                    className="border-gray-200"
                >
                    <h2 className="text-[#edc951] leading-normal mt-[.4em] mb-[.4em]">
                    <span className="inline-block w-[100px] h-[24px] text-[.75em] font-bold align-middle text-[#eb6841] uppercase">
                        {formatDate(note.notePublicationDate)}
                    </span>
                    
                    <div className="inline-block h-[28px] ml-2">
                        <Link 
                        to={`/admin/notes/index?id=${note.noteId}`}
                        className="font-bold text-[1.5em] hover:text-blue-600 transition-colors"
                        >
                        {note.noteTitle}
                        </Link>
                    </div>
                    
                    {note.categoryId ? (
                        <span className="italic font-normal text-[90%] text-gray-500/80 block leading-loose">
                        in{' '}
                        <Link 
                            to={`/admin/categories/index?id=${note.categoryId}`}
                            className="underline hover:text-blue-600 transition-colors"
                        >
                            {note.categoryName}
                        </Link>
                        </span>
                    ) : (
                        <span className="italic font-normal text-[60%] text-gray-500 block leading-8">
                        Без категории
                        </span>
                    )}
                    </h2>
                    
                    {note.subcategoryId && note.subcategoryName && (
                    <span className="underline text-blue-800 visited:text-purple-800 block">
                        <Link 
                        to={`/admin/subcategories/index?id=${note.subcategoryId}`}
                        className="hover:text-blue-600 transition-colors"
                        >
                        Subcategory: {note.subcategoryName}
                        </Link>
                    </span>
                    )}
                    
                    {note.noteAuthors.length > 0 && (
                    <div className="italic text-gray-600">
                        Authors:{' '}
                        {note.noteAuthors.map((author, index) => (
                        <React.Fragment key={author.id}>
                            <Link 
                            to={`/admin/adminusers/index?id=${author.id}`}
                            className="hover:text-blue-600 transition-colors"
                            >
                            {author.login}
                            </Link>
                            {index < note.noteAuthors.length - 1 ? ', ' : ''}
                        </React.Fragment>
                        ))}
                    </div>
                    )}
                    
                    <p 
                    id={`summary-${note.noteId}`} 
                    className="mt-[16px] mb-[16px] pl-[100px] text-gray-700"
                    >
                    {expandedContent[note.noteId] ? (
                        <span dangerouslySetInnerHTML={{ __html: expandedContent[note.noteId] }} />
                    ) : (
                        truncateContent(note.noteContent)
                    )}
                    </p>
                    
                    {loadingContent === note.noteId && (
                    <div className="flex justify-center items-center py-2">
                        <div className="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-500"></div>
                    </div>
                    )}
                    
                   <ul className="ml-0 pl-[10px]">
                        <li className="inline mr-[6px] border border-black p-[3px] text-[12px]">
                            <button
                            onClick={() => handleAjaxPost(note.noteId)}
                            className="ajaxArticleBodyByPost cursor-pointer underline text-blue-800 visited:text-purple-800"
                            >
                            Показать продолжение (POST)
                            </button>
                        </li>
                        
                        <li className="inline mr-[6px] border border-black p-[3px] text-[12px]">
                            <button
                            onClick={() => fetchFullContent(note.noteId)}
                            className="ajaxArticleBodyByGet cursor-pointer underline text-blue-800 visited:text-purple-800"
                            >
                            Показать продолжение (GET)
                            </button>
                        </li>
                        
                        <li className="inline mr-[6px] border border-black p-[3px] text-[12px]">
                            <button
                            onClick={() => handleAjaxPost(note.noteId)}
                            className="ajaxArticlePost cursor-pointer underline text-blue-800 visited:text-purple-800"
                            >
                            (POST) -- NEW
                            </button>
                        </li>
                        
                        <li className="inline mr-[6px] border border-black p-[3px] text-[12px]">
                            <button
                            onClick={() => fetchFullContent(note.noteId)}
                            className="ajaxArticleGet cursor-pointer underline text-blue-800 visited:text-purple-800"
                            >
                            (GET) -- NEW
                            </button>
                        </li>
                    </ul>
                    
                    <div className="text-right">
                    <Link 
                        to={`/admin/notes/index?id=${note.noteId}`}
                        className="text-[14px] underline text-blue-800 hover:text-blue-600 visited:text-purple-800 transition-colors"
                    >
                        Show full article
                    </Link>
                    </div>
                </li>
                ))}
            </ul>
            
            <div className="mt-8 pt-4 border-t border-gray-200">
                <Link 
                to="/?action=archive"
                className="underline text-blue-800 hover:text-blue-600 visited:text-purple-800 transition-colors"
                >
                Article Archive
                </Link>
            </div>
        </div>
    </HomepageLayout>
  );
};

export default Homepage;